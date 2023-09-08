class Calendar 
{
    #year

    #month

    #monthNames

    #week

    #container

    #selectedDate

    #changeMonthCallback

    constructor(settings = {}) 
    {
        this.#year = 
            settings.year ?? new Date().getFullYear()
        this.#month = 
            settings.month ?? new Date().getMonth()
        this.#monthNames = settings.monthNames ?? [
            'January', 'February', 'March', 
            'April', 'May', 'June', 
            'July', 'August', 'September', 
            'October', 'November', 'December'
        ]
        this.#week = settings.week ?? [
            'S', 'M', 'T', 'W', 'T', 'F', 'S'
        ]
        this.#container = $(settings.container)
        this.#selectedDate = null
        this.#changeMonthCallback = settings.changeMonth
        this.#renderMonth()
        $(document).on(
            'click', 
            `${settings.container} .arr.prev`,
            e => this.#prevMonth()
        )
        $(document).on(
            'click', 
            `${settings.container} .arr.next`, 
            e => this.#nextMonth()
        )
        $(document).on(
            'click',
            `${settings.container} .curr-day`,
            e => this.#select(
                e, settings.select
            )
        )
    }

    #renderMonth()
    {
        if (this.#changeMonthCallback) this.#changeMonthCallback({
            year: this.#year,
            month: this.#month,
        })

        const calendar = `
            <div class="calendar">
                <div class="calendar__top">
                    <div class="arr prev">
                    ←
                    </div>
                    <div class="date">
                    ${this.#monthNames[this.#month]} ${this.#year}
                    </div>
                    <div class="arr next">
                    →
                    </div>
                </div>
                <div class="calendar__week">
                    ${this.#renderWeek()}
                </div>
                <div class="calendar__days">
                    ${this.#renderDays()}
                </div>
            </div>`

        this.#container.html(calendar)
    }

    #renderWeek()
    {
        let week = ''
        this.#week.forEach(day => week += `<span>${day}</span>`)

        return week
    }

    #renderDays()
    {
        let days = ''

        // previous month days
        const lastDayPrevMonth = new Date(
            this.#year, 
            this.#month, 
            0
        ).getDay()
        if (lastDayPrevMonth < 6) { // if last day isn't Sat
            for (let i = lastDayPrevMonth; i >= 0; i--) {
                days += `<span class="prev-day">
                        </span>`
            }
        }
        // current month days
        const daysCountCurrMonth = new Date(
            this.#year, 
            this.#month + 1, 
            0
        ).getDate()
        for (let i = 1; i <= daysCountCurrMonth; i++) {
            days += `<span class="curr-day ${this.#isSelected(i) ? 'selected' : ''} ${this.#isToday(i) ? 'today' : ''}">
                        ${i}
                    </span>`
        }
        // next month days
        const lastDayCurrMonth = new Date(
            this.#year, 
            this.#month, 
            daysCountCurrMonth
        ).getDay()
        for (let i = 1; i <= 6 - lastDayCurrMonth; i++) {
            days += `<span class="next-day">
                    </span>`
        }

        return days
    }

    #isSelected(day)
    {
        return this.#selectedDate == `${this.#year}-${this.#month + 1}-${day}`
    }

    #isToday(day)
    {
        if (
            this.#year == new Date().getFullYear() &&
            this.#month == new Date().getMonth() &&
            day == new Date().getDate()
        ) {
            return true
        }

        return false
    }

    #prevMonth()
    {
        const date = new Date(this.#year, this.#month)
        date.setMonth(date.getMonth() - 1)
        this.#year = date.getFullYear()
        this.#month = date.getMonth()

        this.#renderMonth()
    }

    #nextMonth()
    {
        const date = new Date(this.#year, this.#month)
        date.setMonth(date.getMonth() + 1)
        this.#year = date.getFullYear()
        this.#month = date.getMonth()
        
        this.#renderMonth()
    }

    #select(e, callback)
    {
        this.#container
            .find('.curr-day')
            .removeClass('selected')
        $(e.target).addClass('selected')
        const day = parseInt($(e.target).text())
        this.#selectedDate = 
            `${this.#year}-${this.#month + 1}-${day}`
        // call user callback
        if (callback) {
            callback({
                year: this.#year,
                month: this.#month,
                day,
            })
        }
    }

    markUnavailableDays(days) 
    {
        this.#container.find('.curr-day').each((i, day) => {
        if (!days[i].is_free)
            $(day).addClass('unavailable')
        else 
            $(day).removeClass('unavailable')
        })
    }

    getYear()
    {
        return this.#year
    }

    getMonth()
    {
        return this.#month
    }

    getSelectedDate()
    {
        return this.#selectedDate
    }
}
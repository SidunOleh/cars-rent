/**
 * Rent
 */
//date
$(document).on(
    'click',
    '.curr-day.unavailable',
    e => e.stopImmediatePropagation()
)
const rentCalendar = new Calendar({
    container: '#rent-calendar',
    select(date) {
        loading(true, '.rent-info .right')

        // show selected date
        const selectedDate =
            new Date(`${date.year}-${date.month + 1}-${date.day}`)
        $('.selected-date').text(
            selectedDate.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            })
        )

        // unselect hour
        $('.time-variants-item').removeClass('selected')
        selectedHour = null
            // disable hours
        $('.time-variants-item').each((i, hourItem) => {
                const hour =
                    `${date.year}-${date.month + 1}-${date.day}` +
                    ' ' +
                    $(hourItem).attr('data-hour')
                if (
                    new Date(hour) < new Date(new Date().toLocaleString('en-US', { timeZone: 'America/New_York' }))
                ) {
                    $(hourItem).addClass('dissabled')
                } else {
                    $(hourItem).removeClass('dissabled')
                }
            })
            // show hours
        $('.time-select').removeClass('_hidden')

        // hide slots
        $('.hours').addClass('_hidden')
            // hide popup btn
        $('.next-step').addClass('_hidden')

        setTimeout(() => loading(false, '.rent-info .right'), 500)
    },
    changeMonth(date) {
        // mark unavailable days
        $.get(carsharing.ajax_url, {
            action: 'get_days',
            car_id: carsharing.car_id,
            year: date.year,
            month: date.month + 1,
        }).done(res => {
            rentCalendar.markUnavailableDays(res.days)
        })
    },
})

// hours
let selectedHour = null

function chooseHour(e) {
    // select hour
    $('.time-variants-item').removeClass('selected')
    $(e.currentTarget).addClass('selected')

    selectedHour = $(e.currentTarget).attr('data-hour')

    // get slots
    getSlots(
        carsharing.car_id,
        rentCalendar.getSelectedDate(),
        selectedHour
    )
}

$(document).on('click', '.time-variants-item:not(.dissabled)', chooseHour)

// slots
function getSlots(carId, date, hour) {
    loading(true, '.rent-info .right')

    $.get(carsharing.ajax_url, {
        action: 'get_slots',
        car_id: carId,
        date,
        hour,
    }).done(res => {
        renderSlots(res.slots_html)
    }).fail(err => {
        alert('Error. Try again.')
    }).always(res => {
        setTimeout(() => loading(false, '.rent-info .right'), 500)
    })
}

function renderSlots(slotsHtml) {
    $('.hours').replaceWith(slotsHtml)
    $('.next-step').addClass('_hidden')
}

const price = new Proxy({
    total: 0,
}, {
    set(obj, key, val) {
        obj[key] = parseInt(val)
        $('.next-step-popup')
            .find('.total-amount')
            .text('$' + obj[key])
    },
})

function chooseSlot(e) {
    $('.next-step-popup').find('.selected-time')
        .text($(e.target).attr('data-time'))
    let optionsPrice = 0
    $('.characteristics select').each((i, select) => {
        const selected = $(select).find('option:selected')
        optionsPrice += parseInt(selected.attr('data-price'))
    })
    price.total = parseInt($(e.target).attr('data-price')) + optionsPrice
    $('.next-step').removeClass('_hidden')
}

$(document).on('change', '.time-radiobtn', chooseSlot)

// rent popup
function openRentPopup(e) {
    $('.rent-wrapper').toggleClass('hidden')
    $('body').toggleClass('fixed')
}

$('.next-step').click(openRentPopup)

function closeRentPopup(e) {
    $('.rent-wrapper').toggleClass('hidden')
    $('body').toggleClass('fixed')
}

$('.next-step-popup .close').click(closeRentPopup)

// change options
let prev = 0;

function focusOptions(e) {
    const selected = $(e.target).find('option:selected')
    prev = parseInt(selected.attr('data-price'))
}

function changeOptions(e) {
    const selected = $(e.target).find('option:selected')
    price.total -= prev
    price.total += parseInt(selected.attr('data-price'))
    prev = parseInt(selected.attr('data-price'))
}

$('.characteristics select').focus(focusOptions)
$('.characteristics select').change(changeOptions)


// make order
function makeOrder(e) {
    e.preventDefault()

    loading(true, '.next-step-popup')

    const data = new FormData(this)
    data.append('car_id', carsharing.car_id)
    data.append('date', rentCalendar.getSelectedDate())
    data.append('hour', selectedHour)

    $.ajax({
        url: carsharing.ajax_url,
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
    }).done(res => {
        if (res.status == 301) {
            location.href = res.url
        }
    }).fail(jqxhr => {
        if (jqxhr.status == 422) {
            alert(jqxhr.responseJSON.error)
        }
    }).always(res => {
        setTimeout(() => loading(false, '.next-step-popup'), 500)
    })
}

$('#rent-form').submit(makeOrder)


/**
 * Video
 */
const video = document.getElementById('video')
const circlePlayButton = document.getElementById('circle-play-b')

if (video && circlePlayButton) {
    function togglePlay() {
        if (video.paused || video.ended) {
            video.play()
        } else {
            video.pause()
        }
    }

    circlePlayButton.addEventListener('click', togglePlay)

    video.addEventListener('playing', function() {
        circlePlayButton.style.opacity = 0
    })
    video.addEventListener('pause', function() {
        circlePlayButton.style.opacity = 1
    })
}


/**
 * Loading animation
 */
function loading(bool = true, selector = null) {
    const item = $(selector || 'body')
    if (bool) {
        item.addClass('loading')
    } else {
        item.removeClass('loading')
    }
}


/**
 * File input
 */
(function() {
    'use strict'

    $('.input-file').each(function() {
        var $input = $(this),
            $label = $input.next('.js-labelFile'),
            labelVal = $label.html()

        $input.on('change', function(element) {
            var fileName = ''
            if (element.target.value)
                fileName = element.target.value.split('\\').pop()
            fileName
                ?
                $label.addClass('has-file').find('.js-fileName').html(fileName) :
                $label.removeClass('has-file').html(labelVal)
        })
    })
})()
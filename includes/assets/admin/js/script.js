/**
 * Orders
 */
// orders context
const ordersContext = new Proxy({
    date: null,
    carId: $('.carsharing__car.selected').attr('data-car_id'),
}, {
    set(obj, prop, value) {
        obj[prop] = value

        // get orders
        getOrders()

        // mark unavailable days
        $.get(carsharing.ajax_url, {
            action: 'get_days',
            car_id: ordersContext.carId,
            year: ordersCalendar.getYear(),
            month: ordersCalendar.getMonth() + 1,
        }).done(res => {
            ordersCalendar.markUnavailableDays(res.days)
        })
    }
})

// orders calendar
const ordersCalendar = new Calendar({
    container: '#carsharing-calendar',
    // select date
    select(date) {
        year = date.year
        month = String(date.month + 1).padStart(2, 0)
        day = String(date.day).padStart(2, 0)
        ordersContext.date = `${year}-${month}-${day}`
    },
    // change month
    changeMonth(date) {
        // mark unavailable days
        $.get(carsharing.ajax_url, {
            action: 'get_days',
            car_id: ordersContext.carId,
            year: date.year,
            month: date.month + 1,
        }).done(res => {
            ordersCalendar.markUnavailableDays(res.days)
        })
    }
})

$('#carsharing-calendar .today').trigger('click')

// select car
function selectCar(e) {
    const car = $(e.target)
    $('.carsharing__car ').removeClass('selected')
    car.addClass('selected')
    ordersContext.carId = car.attr('data-car_id')
}

$('.carsharing__car').click(selectCar)

// get orders
function getOrders() {
    loading()

    $.get(carsharing.ajax_url, {
        action: 'get_orders_admin',
        car_id: ordersContext.carId,
        date: ordersContext.date,
    }).done(res => {
        $('.carsharing__orders').replaceWith(res.orders_html)
        $('#day-off').prop('checked', res.day_off)
    }).fail(res => {
        alert('Error. Try again.')
    }).always(res => {
        setTimeout(() => loading(false), 500)
    })
}

// delete order
function deleteOrder() {
    if (!confirm('Are you sure?')) return

    const order = $(this).closest('.order-item')
    const orderId = order.attr('data-id')

    loading()

    $.post(carsharing.ajax_url, {
        action: 'delete_order_admin',
        order_id: orderId,
    }).done(res => {
        order.remove()
    }).fail(res => {
        alert('Error. Try again.')
    }).always(res => {
        setTimeout(() => loading(false), 500)
    })
}

$(document).on('click', '.close-order', deleteOrder)

// change pay status
function changePayStatus() {
    const orderId = $(this)
        .closest('.order-item')
        .attr('data-id')

    $.post(carsharing.ajax_url, {
        action: 'change_order_pay_status_admin',
        order_id: orderId,
    }).fail(res => {
        alert('Error. Try again.')
    })
}

$(document).on('change', '#payed', changePayStatus)

// open order popup
function openOrderPopup() {
    $(`#car-id option[value=${ordersContext.carId}]`)
        .prop('selected', true)
    $('#date').val(ordersContext.date)

    Fancybox.show([{ src: '#add-order-popup', type: 'inline' }])
}

$(document).on('click', '#add-order', openOrderPopup)

// add order
function addOrder(e) {
    e.preventDefault()

    loading()

    const data = new FormData(this)

    $.ajax({
        url: carsharing.ajax_url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: res => {
            getOrders()
            $('#add-order-popup .is-close-btn').trigger('click')
            e.target.reset()
        },
        error: jqxhr => {
            res = JSON.parse(jqxhr.responseText)
            if (res.error) {
                alert(res.error)
            } else [
                alert('Error. Try again.')
            ]
        },
        complete: res => {
            setTimeout(() => loading(false), 500)
        }
    })
}

$(document).on('submit', '#add-order-form', addOrder)

// change day off
function changeDayOff(e) {
    $.post(carsharing.ajax_url, {
        action: 'change_day_off',
        car_id: ordersContext.carId,
        date: ordersContext.date,
    })
}

$(document).on('change', '#day-off', changeDayOff)


/**
 * Latest
 */
// get latest
function getLatest(e) {
    loading()

    const page = $(e.target).attr('data-page-number')

    $.get(carsharing.ajax_url, {
        action: 'get_latest_admin',
        page,
    }).done(res => {
        $('.latest').replaceWith(res.latest_html)
        $('.tabs__heading[data-target=latest]').addClass('loaded')
    }).fail(res => {
        alert('Error. Try again.')
    }).always(res => {
        setTimeout(() => loading(false), 500)
    })
}

$(document).on('click', '.latest .pag__arrow:not(.disable)', getLatest)
$(document).on('click', '.tabs__heading[data-target=latest]:not(.loaded)', getLatest)


/**
 * Pricing
 */
// pricing context
const pricingContext = new Proxy({
    date: null,
    carId: $('.pricing__car.selected').attr('data-car_id'),
}, {
    set(obj, prop, value) {
        obj[prop] = value
        getPrices()
    }
})

// pricing calendar
new Calendar({
    container: '#pricing-calendar',
    // select date
    select(date) {
        year = date.year
        month = String(date.month + 1).padStart(2, 0)
        day = String(date.day).padStart(2, 0)
        pricingContext.date = `${year}-${month}-${day}`
    }
})

$('#pricing-calendar .today').trigger('click')

// select car
function pricingSelectCar(e) {
    $('.pricing__car ').removeClass('selected')
    const car = $(e.target)
    car.addClass('selected')
    pricingContext.carId = car.attr('data-car_id')
}

$('.pricing__car').click(pricingSelectCar)

// get prices
function getPrices() {
    loading()

    $.get(carsharing.ajax_url, {
        action: 'get_prices_admin',
        car_id: pricingContext.carId,
        date: pricingContext.date,
    }).done(res => {
        $('.pricing__prices').replaceWith(res.prices_html)
        $('#price-date').text(pricingContext.date.split('-').join('/'))
    }).fail(res => {
        alert('Error. Try again.')
    }).always(res => {
        setTimeout(() => loading(false), 500)
    })
}

// save prices
function savePrices(e) {
    e.preventDefault()

    loading()

    const data = new FormData(this)
    data.append('car_id', pricingContext.carId)
    data.append('date', pricingContext.date)

    $.ajax({
        url: carsharing.ajax_url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        error: res => {
            alert('Error. Try again.')
        },
        complete: res => {
            setTimeout(() => loading(false), 500)
        }
    })
}

$(document).on('submit', '#save-prices-form', savePrices)


/**
 * Analytics
 */
// get charts
function getCharts(e) {
    loading()

    const year = $('#analytics-year option:selected').val()
    const month = $('#analytics-month option:selected').val()

    $.get(carsharing.ajax_url, {
            action: 'get_charts_admin',
            year,
            month,
        })
        .done(res => {
            renderCharts(res)
            $('.tabs__heading[data-target=analytics]').addClass('loaded')
        })
        .fail(res => {
            alert('Error. Try again.')
        })
        .always(res => {
            setTimeout(() => loading(false), 500)
        })
}

// render charts
const charts = {
    ordersCount: null,
    ordersAmount: null,
}

function renderCharts(data) {
    const ordersStatistic = data.orders_statistic
    const cars = []
    const ordersCount = []
    const ordersAmount = []
    for (i in ordersStatistic) {
        cars.push(ordersStatistic[i].post_title)
        ordersCount.push(Number(ordersStatistic[i].orders_count))
        ordersAmount.push(Number(ordersStatistic[i].orders_amount))
    }

    if (charts.ordersCount) {
        charts.ordersCount.destroy()
    }
    charts.ordersCount = new Chart(document.getElementById('orders-count-charts'), {
        type: 'bar',
        data: {
            labels: cars,
            datasets: [{
                label: 'Orders count',
                data: ordersCount,
                borderWidth: 1,
            }]
        },
    })

    if (charts.ordersAmount) {
        charts.ordersAmount.destroy()
    }
    charts.ordersAmount = new Chart(document.getElementById('orders-amount-charts'), {
        type: 'line',
        data: {
            labels: cars,
            datasets: [{
                label: 'Orders amount',
                data: ordersAmount,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    })
}

$(document).on('click', '.tabs__heading[data-target=analytics]:not(.loaded)', getCharts)
$(document).on('change', '#analytics-year, #analytics-month', getCharts)


/**
 * Settings
 */
// save settings
function saveSettings(e) {
    e.preventDefault()

    loading()

    const data = $(this).serialize()

    $.post(carsharing.ajax_url, data)
        .fail(res => {
            alert('Error. Try again.')
        }).always(res => {
            setTimeout(() => loading(false), 500)
        })
}

$('#carsharing-settings-form').submit(saveSettings)


/**
 * Tabs
 */
// select tab
function selectTab(e) {
    const selectedTab = $(e.target)
    const target =
        selectedTab.attr('data-target')
    const targetItem =
        $(`.tabs__item[data-page=${target}]`)

    $('.tabs__heading, .tabs__item')
        .removeClass('selected')
    selectedTab.addClass('selected')
    window.location.hash = target
    targetItem.addClass('selected')
}

$('.tabs__heading').bind('click', selectTab)

// select tab after download
const tab = window.location.hash.substring(1) || 'orders'
$(`.tabs__heading[data-target=${tab}]`)
    .trigger('click')


/**
 * Loading animation
 */
function loading(bool = true, selector = null) {
    const item = $(selector || '#wpcontent')
    if (bool) {
        item.addClass('loading')
    } else {
        item.removeClass('loading')
    }
}


/**
 * Fancybox
 */
Fancybox.bind('[data-fancybox]', {})


/**
 * Accordion
 */
$(document).on('click', '.accordion__title', openContent)

function openContent(e) {
    const content = $(e.currentTarget).next()
    content.toggleClass('show')
}
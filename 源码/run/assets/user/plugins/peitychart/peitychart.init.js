(function($){

 "use strict"; // Start of use strict

$(function() {
    "use strict";
    // Just the defaults.
    $("span.pie").peity("pie",{
        width: '80',
        height: '80'
    })

    $('span.donut').peity('donut',{
        width: '50',
        height: '50'
    })


    $(".peity-line").peity("line",{
        width: '100%',
        height: '65',
		fill:['#705ec8']
    })

    $(".bar").peity("bar",{
        width: '100%',
        height: '50'
    })

    $(".bar-colours-1").peity("bar", {
        fill: ["#705ec8", "#fa057a", "#2dce89"],
        width: '100',
        height: '100'
    })

    $(".bar-colours-2").peity("bar", {
        fill: function(value) {
            return value > 0 ? "#ff5b51" : "#fcbf09"
        },
        width: '100',
        height: '100'
    })

    $(".bar-colours-3").peity("bar", {
        fill: ["#2dce89", "#ff5b51"],
        width: '100',
        height: '100'
    })

    $(".pie-colours-1").peity("pie", {
        fill: ["#705ec8", "#fa057a", "#2dce89", "#ff5b51"],
        width: '100',
        height: '100'
    })

    $(".pie-colours-2").peity("pie", {
		fill: ["#705ec8", "#fa057a", "#2dce89", "#ff5b51", "#fcbf09"],
        width: '100',
        height: '100'
    })

    // Using data attributes
    $(".data-attributes span").peity("donut")

    // Evented example.
    $("select").change(function() {
        var text = $(this).val() + "/" + 5
		
        $(this)
            .siblings("span.graph")
            .text(text)
            .change()

        $("#notice").text("Chart updated: " + text)
    }).change()

    $("span.graph").peity("pie")

    // Updating charts.
    var updatingChart = $(".updating-chart").peity("line", { width: "100%",height:65 })

    setInterval(function() {
        var random = Math.round(Math.random() * 20)
        var values = updatingChart.text().split(",")
        values.shift()
        values.push(random)

        updatingChart
            .text(values.join(","))
            .change()
    }, 2500)
})


})(jQuery);

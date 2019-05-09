function loadEvents() {
    $.ajax({
        type: "GET",
        url: "http://localhost/NetMap/route/route_event.php?fetch_all_eventsForMap=1",
        success: function(response) {
            console.log(response);
        },
        dataType: 'json'
    });
}

loadEvents();
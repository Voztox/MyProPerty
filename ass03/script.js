$(document).ready(function() {
    // Initialize draggable behavior for filters
    $(".filter").draggable({
        revert: "invalid",
        helper: "clone"
    });

    // Initialize droppable behavior for filter container
    $("#filterContainer").droppable({
        accept: ".filter",
        drop: function(event, ui) {
            // Append dropped filter to container
            $(this).append(ui.helper.clone());
            // Apply filter logic here
            // This is where you would update the property search based on the selected filters
        }
    });
});

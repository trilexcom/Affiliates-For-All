function graphCachePopulated() {
    $("#com30").attr("src", "graph.php?variable=commission&days=30");
    $("#com90").attr("src", "graph.php?variable=commission&days=90");
    $("#ord7").attr("src", "graph.php?variable=orders&days=7");
    $("#ord30").attr("src", "graph.php?variable=orders&days=30");
    $("#ord90").attr("src", "graph.php?variable=orders&days=90");
}

$(function() {
    $("#tabs > ul").tabs();
    $("#com7").attr("src", "graph.php?variable=commission&days=7&fromcache=0");
    $("#com7").load(graphCachePopulated);
});

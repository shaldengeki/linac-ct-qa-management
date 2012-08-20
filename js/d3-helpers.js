function getDate(d) {
    return new Date(d.x);
}

function displayFormFieldLineGraph(data, title, div_id) {
  // get max and min dates - this assumes data is sorted
  var minDate = getDate(data[0]),
      maxDate = getDate(data[data.length-1]),
      minValue = Math.min.apply(Math,data.map(function(o){return o.y;})),
      maxValue = Math.max.apply(Math,data.map(function(o){return o.y;}));
  var w = 300,
  h = 200,
  p = 30,
  y = d3.scale.linear().domain([minValue, maxValue]).range([h, 0]),
  x = d3.time.scale().domain([minDate, maxDate]).range([0, w]);
  /*if (title == 'Energy Ratio 9mev Diff') {
    alert(minValue + " | " + maxValue + y.ticks(10));
  }*/

  var vis = d3.select("#"+div_id)
  .data([data])
    .append("svg:svg")
    .attr("width", w + p * 2)
    .attr("height", h + p * 2)
    .append("svg:g")
    .attr("transform", "translate(" + p + "," + p + ")");

   var rules = vis.selectAll("g.rule")
      .data(x.ticks(10))
     .enter().append("svg:g")
       .attr("class", "rule");

   // Draw grid lines
   rules.append("svg:line")
    .attr("x1", x)
    .attr("x2", x)
    .attr("y1", 0)
    .attr("y2", h - 1);

   rules.append("svg:line")
    .attr("class", function(d) { return d ? null : "axis"; })
    .data(y.ticks(10))
    .attr("y1", y)
    .attr("y2", y)
    .attr("x1", 0)
    .attr("x2", w + 1);

    rules.append("svg:text")
    .attr("x", x)
    .attr("y", h + 3)
    .attr("dy", ".71em")
    .attr("text-anchor", "middle")
    .text(x.tickFormat(10));

    rules.append("svg:text")
    .data(y.ticks(10))
    .attr("y", y)
    .attr("x", -3)
    .attr("dy", ".35em")
    .attr("text-anchor", "end")
    .text(y.tickFormat(10));

    
  vis.append("svg:path")
  .attr("class", "line")
  .attr("d", d3.svg.line()
      .x(function(d) { return x(getDate(d)) })
      .y(function(d) { return y(d.y) })
  );

  vis.selectAll("circle.line")
  .data(data)
  .enter().append("svg:circle")
  .attr("class", "line")
  .attr("cx", function(d) { return x(getDate(d)) })
  .attr("cy", function(d) { return y(d.y); })
  .attr("r", 3.5);
  
  vis.append("svg:text")
     .attr("x", w/4)
     .attr("y", 20)
     .text(title);
}
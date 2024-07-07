const data = [
    { date: '2024-01-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-02-01', productA: 60 + Math.random() * 20, productB: 70 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-03-01', productA: 45 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-04-01', productA: 55 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-05-01', productA: 55 + Math.random() * 20, productB: 70 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-06-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 90 + Math.random() * 20 },
    { date: '2024-07-01', productA: 60 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 130 + Math.random() * 20 },
    { date: '2024-08-01', productA: 72 + Math.random() * 20, productB: 52 + Math.random() * 20, productC: 78 + Math.random() * 20 },
    { date: '2024-09-01', productA: 68 + Math.random() * 20, productB: 100 + Math.random() * 20, productC: 140 + Math.random() * 20 },
    { date: '2024-10-01', productA: 125 + Math.random() * 20, productB: 90 + Math.random() * 20, productC: 70 + Math.random() * 20 },
    { date: '2024-12-31', productA: 120 + Math.random() * 20, productB: 120 + Math.random() * 20, productC: 60 + Math.random() * 20 }
];

const parseDate = d3.timeParse("%Y-%m-%d");

data.forEach(d => {
  d.date = parseDate(d.date);
});

const margin = { top: 20, right: 30, bottom: 50, left: 50 };
const width = 960 - margin.left - margin.right;
const height = 500 - margin.top - margin.bottom;

const svg = d3.select("#chart")
  .append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
  .append("g")
  .attr("transform", `translate(${margin.left},${margin.top})`);

const x0 = d3.scaleBand()
  .domain(data.map(d => d.date))
  .rangeRound([0, width])
  .paddingInner(0.1);

const x1 = d3.scaleBand()
  .domain(['productA', 'productB', 'productC'])
  .rangeRound([0, x0.bandwidth()])
  .padding(0.05);

const y = d3.scaleLinear()
  .domain([0, d3.max(data, d => Math.max(d.productA, d.productB, d.productC))])
  .nice()
  .range([height, 0]);

const xAxis = d3.axisBottom(x0).tickFormat(d3.timeFormat("%Y-%m-%d"));
const yAxis = d3.axisLeft(y);

svg.append("g")
  .attr("class", "x-axis")
  .attr("transform", `translate(0,${height})`)
  .call(xAxis)
  .selectAll("text")
  .attr("transform", "rotate(-45)")
  .style("text-anchor", "end");

svg.append("g")
  .attr("class", "y-axis")
  .call(yAxis);

svg.selectAll("g.layer")
  .data(data)
  .enter().append("g")
  .attr("class", "layer")
  .attr("transform", d => `translate(${x0(d.date)},0)`)
  .selectAll("rect")
  .data(d => ['productA', 'productB', 'productC'].map(key => ({ key, value: d[key] })))
  .enter().append("rect")
  .attr("x", d => x1(d.key))
  .attr("y", d => y(d.value))
  .attr("width", x1.bandwidth())
  .attr("height", d => height - y(d.value))
  .attr("class", d => `bar ${d.key}`);

const line = d3.line()
  .x(d => x0(d.date) + x0.bandwidth() / 2)
  .y(d => y(d.value));

const products = ['productA', 'productB', 'productC'];

products.forEach(product => {
  svg.append("path")
    .datum(data.map(d => ({ date: d.date, value: d[product] })))
    .attr("class", `line ${product}`)
    .attr("d", line)
    .attr("fill", "none")
    .attr("stroke-width", 2);
});

const legend = svg.selectAll(".legend")
  .data(['Product A', 'Product B', 'Product C'])
  .enter().append("g")
  .attr("class", "legend")
  .attr("transform", (d, i) => `translate(0,${i * 20})`);

legend.append("rect")
  .attr("x", width - 18)
  .attr("width", 18)
  .attr("height", 18)
  .style("fill", (d, i) => ["steelblue", "green", "red"][i]);

legend.append("text")
  .attr("x", width - 24)
  .attr("y", 9)
  .attr("dy", ".35em")
  .style("text-anchor", "end")
  .text(d => d);

  // Existing D3.js code here...

document.getElementById("download").addEventListener("click", function() {
    const svgElement = document.querySelector("#chart svg");
    
    // Use html2canvas to capture the SVG
    html2canvas(svgElement, {
        useCORS: true,
        backgroundColor: null
    }).then(function(canvas) {
        // Create a link element to download the canvas as an image
        const downloadLink = document.createElement("a");
        downloadLink.href = canvas.toDataURL("image/png");
        downloadLink.download = "chart.png";
        downloadLink.click();
    }).catch(function(error) {
        console.error("Error capturing the SVG:", error);
    });
});


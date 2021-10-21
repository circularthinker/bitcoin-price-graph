<!DOCTYPE html>
<html>

<head>
  <title>Bitcoin Price Graph</title>
  <!-- Latest CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>

<body>
  <div>
    <label for="start">Start date:</label>

    <input type="date" id="start" name="trip-start" value="">

    <label for="start">End date:</label>

    <input type="date" id="end" name="trip-start" value="">
    <button id="render">Render</button>
  </div>
  <div class="chart-container">
    <div class="pie-chart-container">
      <canvas id="canvas" height="280" width="600"></canvas>
    </div>
  </div>
  <script>
    
    $(document).ready(function() {
      var databitcoin;
      const datesarr = [];
      const pricearr = [];

      function pad2(n) {
        return (n < 10 ? '0' : '') + n;
      }
      var date = new Date(Date.now() - 10 * 24 * 60 * 60 * 1000);
      var month = pad2(date.getMonth() + 1); //months (0-11)
      var day = pad2(date.getDate()); //day (1-31)
      var year = date.getFullYear();

      var startdt = year + "-" + month + "-" + day;
      //var startdt=Date('yyyy-mm-dd');
      var date2 = new Date();
      var month2 = pad2(date2.getMonth() + 1); //months (0-11)
      var day2 = pad2(date2.getDate()); //day (1-31)
      var year2 = date2.getFullYear();
      var enddt = year2 + "-" + month2 + "-" + day2;
      document.getElementById("start").value = startdt;
      document.getElementById("end").value = enddt;
      const api_url =
        "https://api.coindesk.com/v1/bpi/historical/close.json?start=" + startdt + "&end=" + enddt + "&index=[USD]";
      var response = fetch(api_url).then((response) => {
          return response.json();
        })
        .then((data) => {
          //console.log(data.bpi);
          for (let x in data.bpi) {
            //console.log(x + ": "+ data.bpi[x])
            //console.log(x);
            datesarr.push(x);
            pricearr.push(data.bpi[x]);
            //console.log(pricearr);
          }
        });
      //console.log(datesarr);
      var lineChartData = {
        labels: datesarr,
        datasets: [{
          label: 'Bitcoin Price',
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          data: pricearr
        }]
      };


      //console.log(lineChartData);
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx, {
        type: 'line',
        data: lineChartData,
        options: {
          responsive: true,
          title: {
            display: true,
            text: 'Bitcoin Price'
          }
        }
      });
      $("#render").click(function() {
        var startdt = document.getElementById("start").value;
        var enddt = document.getElementById("end").value;

        //alert(startdt);
        var databitcoin;
        const datesarr = [];
        const pricearr = [];

        document.getElementById("start").value = startdt;
        document.getElementById("end").value = enddt;
        const api_url =
          "https://api.coindesk.com/v1/bpi/historical/close.json?start=" + startdt + "&end=" + enddt + "&index=[USD]";
        var response = fetch(api_url).then((response) => {
            return response.json();
          })
          .then((data) => {
            //console.log(data.bpi);
            for (let x in data.bpi) {
              //console.log(x + ": "+ data.bpi[x])
              //console.log(x);
              datesarr.push(x);
              pricearr.push(data.bpi[x]);
              //console.log(pricearr);
            }
          });
        //var data = myBar.data;
        //data.datasets.data = pricearr;
        //data.labels = datesarr;
        //myBar.update();
        window.myBar.destroy();
        var lineChartData = {
        labels: datesarr,
        datasets: [{
          label: 'Bitcoin Price',
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          data: pricearr
        }]
      };
        var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx, {
        type: 'line',
        data: lineChartData,
        options: {
          responsive: true,
          title: {
            display: true,
            text: 'Bitcoin Price'
          }
        }
      });
      });

    });
  </script>
</body>

</html>
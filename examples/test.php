<?php

require_once dirname(__FILE__) . '/../src/ChromePDF.php';

use Royalty\ChromePDF\ChromePDF as ChromePDF;

// test 1: render a real data URI to see if it works
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->loadHTML("<h1>Hello World! If you see this, this library works!</h1>");
$chromepdf->save(output_path: 'test01.pdf', verbose: true);

// test 2: render a real website to see if it works
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://example.com/");
$chromepdf->save(output_path: 'test02.pdf', verbose: true);

// test 3: render a real website but set a window size
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://example.com/");
$chromepdf->setWindowSize(width: 1920, height: 1080);
$chromepdf->save(output_path: 'test03.pdf', verbose: true);

// test 4: render a real website but set a window size
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://viewportsizer.com/what-is-my-screen-size/");
$chromepdf->setWindowSize(width: 1920, height: 1080);
$chromepdf->setPDFHeaders(false);
$chromepdf->save(output_path: 'test04.pdf', verbose: true);

// test 5: render a real website but turn off margins
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://example.com/");
$chromepdf->setMargins(false);
$chromepdf->save(output_path: 'test05.pdf', verbose: true);

// test 6: render a page, see if time wait is being respected
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->loadHTML("<!DOCTYPE html>
<html>
<head>
  <title>Time Since Page Loaded</title>
  <script>
    var startTime = Date.now();
    function updateTime() {
      var elapsed = Date.now() - startTime; // milliseconds
      document.getElementById('timer').textContent = (elapsed / 1000).toFixed(2) + ' seconds';
    }
    setInterval(updateTime, 100); // update every 100ms
  </script>
</head>
<body>
  <h1>Time since page loaded:</h1>
  <div id='timer'>0.00 seconds</div>
</body>
</html>");
$chromepdf->setRenderWait(1000);
$chromepdf->save(output_path: 'test06.pdf', verbose: true);

// test 7: render a page, see if improve rendering quality is being respected
// personally, i cannot tell the difference.
$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://google.com/");
$chromepdf->setGPUAcceleration(true);
$chromepdf->improveRenderingQuality(false);
$chromepdf->save(output_path: 'test07a.pdf', verbose: true);

$chromepdf = new ChromePDF(binary_path: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome');
$chromepdf->setURL("https://google.com/");
$chromepdf->setGPUAcceleration(true);
$chromepdf->improveRenderingQuality(true);
$chromepdf->save(output_path: 'test07b.pdf', verbose: true);

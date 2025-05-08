<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Multi Modulation CubeSat Packet Decoder</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #0f172a;
      background-image: url('3d-rendering-dark-earth-space.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      color: #f8fafc;
      margin: 0;
      padding: 20px;
    }

    /* Navbar styles */
    .navbar {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .navbar button {
      background-color: #334155;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      color: #f8fafc;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .navbar button:hover {
      background-color: #475569;
    }

    h1 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background-color: #1e293b;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }

    select, input[type="file"] {
      margin: 10px 0;
      padding: 10px;
      border-radius: 8px;
      border: none;
      font-size: 1rem;
      background-color: #334155;
      color: #f1f5f9;
      width: 100%;
    }

    .output-section {
      margin-top: 20px;
    }

    .output-section h2 {
      font-size: 1.2rem;
      margin-bottom: 8px;
    }

    pre {
      background-color: #0f172a;
      border-left: 4px solid #22d3ee;
      padding: 15px;
      border-radius: 8px;
      white-space: pre-wrap;
      word-break: break-word;
      overflow-x: auto;
    }
  </style>
</head>
<body>

  <!-- Navigation bar -->
  <nav class="navbar">
    <button onclick="location.href='index.php'">Home</button>
    <button onclick="location.href='about.html'">About</button>
    <button onclick="location.href='contact.html'">Contact</button>
  </nav>

  <h1 id="home"> Multi Modulation CubeSat Packet Decoder </h1>

  <div class="container">
    <label for="modulation">Select Modulation Scheme:</label>
    <select id="modulation">
      <option value="AFSK">AFSK</option>
      <option value="FSK">FSK</option>
      <option value="GFSK">GFSK</option>
      <option value="BPSK">BPSK</option>
      <option value="QPSK">QPSK</option>
      <option value="LoRa">LoRa</option>
    </select>

    <label for="fileInput">Import HEX .bin File:</label>
    <input type="file" id="fileInput" accept=".bin" />

    <div class="output-section">
      <h2>📂 Raw HEX View:</h2>
      <pre id="hexOutput">Hex data will appear here...</pre>

      <h2>📢 Decoded Telemetry View:</h2>
      <pre id="asciiOutput">Decoded packet will appear here...</pre>
    </div>
  </div>

  <!-- Dummy sections for Features, About, and Contact -->
  <!-- Removed Features section -->

  <div class="container" id="about" style="margin-top:40px;">
    <h2>ℹ️ About</h2>
    <p>This tool helps decode CubeSat telemetry packets encoded with different modulation techniques. Built for satellite enthusiasts and developers!</p>
  </div>

  <div class="container" id="contact" style="margin-top:40px; margin-bottom: 40px;">
    <h2>📞 Contact</h2>
    <p>For feedback or support, reach out at <strong>pchetry235@gmail.com</strong>.</p>
  </div>

  <script>
    function hexToText(hex) {
      const hexes = hex.match(/.{1,2}/g) || [];
      return hexes.map(h => String.fromCharCode(parseInt(h, 16))).join('');
    }

    function parseTelemetry(content) {
      const fields = content.split('|');
      if (fields.length < 18) return 'Invalid telemetry format';

      return `🛰️ Satellite: ${fields[2]}
🕒 Timestamp: ${fields[1]}
📍 Location: (${fields[3]})
🔋 Battery: ${fields[4]}%
📡 Radio: ${fields[5] === '1' ? 'Active' : 'Inactive'}
🧠 OBC: ${fields[6] === '1' ? 'Operational and stable' : 'Error'}
🎯 ADCS: ${fields[7] === '1' ? 'Operational and stable' : 'Error'}
⚡ EPS: ${fields[8] === '1' ? 'Operational and stable' : 'Error'}
🔋 Batteries: ${fields[9] === '1' ? 'Operational and stable' : 'Error'}
🧭 Orientation:
  X Axis = ${fields[10]}
  Y Axis = ${fields[11]}
  Z Axis = ${fields[12]}
🔆 Power Generation:
  X Panel = ${fields[13]}W
  X+ Panel = ${fields[14]}W
  Y Panel = ${fields[15]}W
  Y+ Panel = ${fields[16]}W
  Z Panel = ${fields[17]}W
  Z+ Panel = ${fields[18]}W
🛰️ NORAD ID: ${fields[19]}
📄 TLE:
${fields[20]}
${fields[21]}`;
    }

    document.getElementById('fileInput').addEventListener('change', function (event) {
      const file = event.target.files[0];
      if (!file) return;

      const selectedModulation = document.getElementById('modulation').value;

      const reader = new FileReader();
      reader.onload = function (e) {
        const hexText = new TextDecoder().decode(e.target.result);
        const decodedText = hexToText(hexText);
        const fields = decodedText.split('|');
        const contentModulation = fields[0];

        if (contentModulation !== selectedModulation) {
          alert(`Modulation mismatch! File appears to be for ${contentModulation}, but you selected ${selectedModulation}.`);
          return;
        }

        document.getElementById('hexOutput').textContent = hexText;
        document.getElementById('asciiOutput').textContent = parseTelemetry(decodedText);
      };
      reader.readAsArrayBuffer(file);
    });
  </script>
</body>
</html>

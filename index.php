<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Rate Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Calculate</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="voltage">Voltage</label>
                <input type="number" step="0.01" class="form-control" id="voltage" name="voltage" required
                       value="<?php echo isset($_POST['voltage']) ? $_POST['voltage'] : ''; ?>">Voltage (V)
            </div>
            <div class="form-group">
                <label for="current">Current</label>
                <input type="number" step="0.01" class="form-control" id="current" name="current" required
                       value="<?php echo isset($_POST['current']) ? $_POST['current'] : ''; ?>">Ampere (A)
            </div>
            <div class="form-group">
                <label for="rate">CURRENT RATE</label>
                <input type="number" step="0.01" class="form-control" id="rate" name="rate" required
                       value="<?php echo isset($_POST['rate']) ? $_POST['rate'] : ''; ?>">sen/kWh
            </div>
            <button type="submit" class="btn btn-primary">calculate</button>
        </form>

         <?php
        // Fungsi untuk mengira kuasa dalam kilowatt (kW)
        function calculatePower($voltage, $current) {
            return ($voltage * $current) / 1000; // Mengira kuasa dalam kW
        }

        // Fungsi untuk menukar kadar dari sen ke RM
        function convertRateToRM($rate) {
            return $rate / 100;
        }

        // Fungsi untuk mengira penggunaan tenaga dalam kWh
        function calculateEnergy($power, $hour) {
            return $power * $hour; // Mengira tenaga dalam kWh
        }

        // Fungsi untuk mengira jumlah kos
        function calculateTotalCost($energy, $rate_in_rm) {
            return $energy * $rate_in_rm; // Mengira jumlah kos dalam RM
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            // Kira kuasa dalam kW
            $power_kw = calculatePower($voltage, $current);

            // Tukar kadar ke RM
            $rate_in_rm = convertRateToRM($rate);

            $customBlue = "#007bff";

            // Paparkan keputusan kuasa dan kadar
            echo "<div class='p-3 mt-4' style='border: 2px solid $customBlue; background-color: white;'>
                <strong style='color: $customBlue;'>POWER :</strong> <strong style='color: $customBlue;'>" . number_format($power_kw, 5) . "kW</strong><br>
                <strong style='color: $customBlue;'>RATE :</strong> <strong style='color: $customBlue;'>" . number_format($rate_in_rm, 3) . "RM</strong>
            </div>";

            echo "<h3 class='mt-4'></h3>";
            echo "<table class='table table-bordered'>";
            echo "<thead>
                <tr>
                    <th>#</th>
                    <th>Hour</th>
                    <th>Energy (kWh)</th>
                    <th>Total (RM)</th>
                </tr>
                </thead>";
            echo "<tbody>";

            // Kira penggunaan tenaga dan jumlah kos untuk setiap jam
            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = calculateEnergy($power_kw, $hour);
                $total = calculateTotalCost($energy, $rate_in_rm);

                echo "<tr><td><strong>$hour</strong></td><td>$hour</td><td>" . number_format($energy, 5) . "</td><td>" . number_format($total, 2) . "</td></tr>";
            }
            echo "</tbody></table>";
        }
        ?>
    </div>
</body>
</html>




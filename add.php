<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add a new booking record at Bukit Pandan Hotel.">
    <title>Add New Booking Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #000000;
        }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: bold;
            margin-top: 1rem;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            margin-top: 1.5rem;
            background-color: #FFD700;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #000000;
            color: white;
            transition: background-color 0.3s ease-in;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Booking Record</h1>
        <form action="submit_new_record.php" method="post">
            <label for="customer-name">Customer Name</label>
            <input type="text" id="customer-name" name="customerName" required>

            <label for="room-number">Room Number</label>
            <select id="room-number" name="room_number" required>
                <!-- Room numbers will be populated dynamically based on room type -->
            </select>

            <label for="room-type">Room Type</label>
            <select id="room-type" name="room_type" required>
                <option value="standard" data-price="110">Standard Room - RM110/night</option>
                <option value="deluxe" data-price="220">Deluxe Room - RM220/night</option>
                <option value="executive" data-price="350">Executive Room - RM350/night</option>
            </select>

            <label for="num-guests">Number of Guests</label>
            <input type="text" id="num-guests" name="num_guests" required>

            <label for="check-in">Check-in Date</label>
            <input type="date" id="check-in" name="check_in" required>

            <label for="check-out">Check-out Date</label>
            <input type="date" id="check-out" name="check_out" required>

            <label for="total-payment">Total Payment (RM)</label>
            <input type="text" id="total-payment" name="total_payment" readonly>

            <label for="requests">Special Requests</label>
            <textarea id="requests" name="special_requests" rows="4" placeholder="Any specific requirements or preferences"></textarea>

            <button type="submit">Confirm Booking</button>
        </form>
    </div>

    <script>
        // Event listener to update available room numbers based on room type
        document.getElementById('room-type').addEventListener('change', updateRoomNumbers);
        document.getElementById('check-in').addEventListener('change', calculatePayment);
        document.getElementById('check-out').addEventListener('change', calculatePayment);

        function updateRoomNumbers() {
            const roomType = document.getElementById('room-type').value;
            const roomNumberSelect = document.getElementById('room-number');
            roomNumberSelect.innerHTML = ''; // Clear previous room numbers

            let startRoom, endRoom;
            if (roomType === 'standard') {
                startRoom = 1;
                endRoom = 50;
            } else if (roomType === 'deluxe') {
                startRoom = 51;
                endRoom = 100;
            } else if (roomType === 'executive') {
                startRoom = 101;
                endRoom = 150;
            }

            for (let i = startRoom; i <= endRoom; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Room ${i}`;
                roomNumberSelect.appendChild(option);
            }
        }

        function calculatePayment() {
            const roomType = document.getElementById('room-type');
            const checkIn = new Date(document.getElementById('check-in').value);
            const checkOut = new Date(document.getElementById('check-out').value);
            const pricePerNight = parseInt(roomType.options[roomType.selectedIndex].dataset.price || 0);

            if (checkIn && checkOut && pricePerNight) {
                const nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
                const totalPayment = nights > 0 ? nights * pricePerNight : 0;
                document.getElementById('total-payment').value = totalPayment.toFixed(2);
            } else {
                document.getElementById('total-payment').value = '';
            }
        }

        // Initialize the room numbers based on the default room type
        updateRoomNumbers();
    </script>
</body>
</html>

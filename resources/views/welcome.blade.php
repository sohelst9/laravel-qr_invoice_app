<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            height: 100vh;
            /* Full viewport height */
            margin: 0;
            /* Remove default margin */
        }

        .scan_ticket {
            text-align: center;
            /* Center text within the div */
        }

        .scan_ticket_btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
            /* Space between buttons */
        }

        /* Hover effect for Scan Ticket */
        .scan_ticket_btn:hover {
            background-color: #0056b3;
            /* Darker background on hover */
        }

        .user_list {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1rem;
            color: #fff;
            background-color: #28a745;
            /* Green background */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for User List */
        .user_list:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Responsive styles */
        @media (max-width: 768px) {

            .scan_ticket_btn,
            .user_list {
                padding: 10px 20px;
                /* Adjust padding for smaller screens */
                font-size: 0.9rem;
                /* Adjust font size for smaller screens */
            }
        }
    </style>
</head>

<body>
    <div class="scan_ticket">
        <a id="scanButton" class="scan_ticket_btn">Scan Ticket</a>
        <a href="{{ route('users') }}" class="user_list">User List</a>
    </div>


    <script>
        document.getElementById('scanButton').onclick = function() {
            var html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText, decodedResult) => {
                    // Handle the scanned result
                    $.post('/scan', {
                        unique_id: decodedText,
                        _token: '{{ csrf_token() }}'
                    }).done(function(data) {
                        alert(data.message);
                    }).fail(function(xhr) {
                        alert(xhr.responseJSON.message);
                    });
                },
                (errorMessage) => {
                    // Handle scan error
                }
            ).catch(err => {
                console.error(err);
            });
        }
    </script>
</body>

</html>

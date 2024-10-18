{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
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

</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@zxing/browser@latest"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .scan_ticket {
            text-align: center;
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
        }
        .scan_ticket_btn:hover {
            background-color: #0056b3;
        }
        #video {
            display: none; /* Initially hide the video element */
            width: 300px;
            height: 300px;
            margin-top: 20px; /* Add some margin above the video */
        }
    </style>
</head>
<body>

    <div class="scan_ticket">
        <a id="scanButton" class="scan_ticket_btn">Scan Ticket</a>
        <video id="video"></video>
    </div>

    <script>
        document.getElementById('scanButton').onclick = function() {
            const codeReader = new ZXing.BrowserQRCodeReader();
            const videoElement = document.getElementById('video');
            videoElement.style.display = 'block'; // Show the video element

            codeReader.decodeFromVideoDevice(null, videoElement, (result, err) => {
                if (result) {
                    alert('QR Code: ' + result.text); // Show the scanned QR code
                    $.post('/scan', {
                        unique_id: result.text,
                        _token: '{{ csrf_token() }}'
                    }).done(function(data) {
                        alert(data.message);
                    }).fail(function(xhr) {
                        alert(xhr.responseJSON.message);
                    });

                    // Stop scanning after success
                    codeReader.reset();
                    videoElement.style.display = 'none'; // Hide the video element
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    console.error(err);
                }
            });
        };
    </script>

</body>
</html>


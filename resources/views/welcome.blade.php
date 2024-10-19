<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

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
            cursor: pointer;
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

        .reader {
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
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
        <div id="reader" class="reader"></div>
    </div>

    <!-- Success মেসেজের জন্য কাস্টম ডায়ালগ -->
    <div id="successMessage" style="display:none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px;">
        <!-- এখানে মেসেজটি সেট হবে -->
    </div>

    <script>
        var isScanning = false; // স্ক্যানিং স্টেট

        document.getElementById('scanButton').onclick = function() {
            var html5QrCode = new Html5Qrcode("reader");

            // স্ক্যানার শুরু করা
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10, // প্রতি সেকেন্ডে ফ্রেম
                    qrbox: 250 // স্ক্যানার বক্সের সাইজ
                },
                (decodedText, decodedResult) => {
                    // যদি স্ক্যানিং ইতিমধ্যে হচ্ছে তবে কিছু করা হবে না
                    if (isScanning) return;

                    isScanning = true; // স্ক্যানিং শুরু হয়েছে
                    // স্ক্যান হওয়া ডেটা (unique_id) সার্ভারে পাঠানো
                    $.post('/scan', {
                        unique_id: decodedText,
                        _token: '{{ csrf_token() }}'
                    }).done(function(data) {
                        // Success মেসেজ দেখানো
                        var successMessage = document.getElementById('successMessage');
                        successMessage.innerText = data; // সার্ভার থেকে আসা মেসেজটি সেট করা
                        successMessage.style.display = 'block'; // মেসেজ দেখানো

                        // মেসেজ ৩ সেকেন্ড পরে বন্ধ করা
                        setTimeout(function() {
                            successMessage.style.display = 'none'; // মেসেজ হাইড করা

                            // স্ক্যানার বন্ধ করা
                            html5QrCode.stop().then(() => {
                                document.getElementById('reader').innerHTML = ""; // UI থেকে স্ক্যানার সরানো
                                isScanning = false; // স্ক্যানিং শেষ হয়েছে
                            }).catch(err => {
                                console.error("Failed to stop the scanner.", err);
                                isScanning = false; // স্ক্যানিং শেষ হচ্ছে
                            });
                        }, 3000); // ৩ সেকেন্ড পরে মেসেজ এবং স্ক্যানার বন্ধ হবে

                    }).fail(function(xhr) {
                        alert(xhr.responseJSON.message);
                        isScanning = false; // স্ক্যানিং শেষ হবে যদি কিছু ভুল হয়
                    });
                },
                (errorMessage) => {
                    // স্ক্যানিং এর সময় কোনো ত্রুটি হলে হ্যান্ডেল করা
                    console.error(errorMessage);
                }
            ).catch(err => {
                console.error(err);
            });
        }
    </script>
</body>




</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search place</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            label{
                display: block;
                width: 200px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
                background-color: #04AA6D;
                color: white;
            }
            #loadingIndicator {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
            }

            .spinner {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #3498db;
                border-radius: 50%;
                animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: translate(-50%, -50%) rotate(0deg);
                }
                100% {
                    transform: translate(-50%, -50%) rotate(360deg);
                }
            }

        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body class="antialiased">
    <h3 style="text-align: center">Search house</h3>
    <hr>
    <div>
        <form onsubmit="return false;" style="display: flex;align-content: space-around; justify-content: space-around;">
            <label for="">Name:
                <input type="text" name="name"/>
            </label>
            <label for="">Price:
                <input type="number" placeholder="from" name="price[x]"/>
                <input type="number" placeholder="to" name="price[y]"/>
            </label>
            <label for="">
                Bathrooms:
                <input type="number" name="bathrooms"/>
            </label>
            <label for="">
                Bedrooms:
                <input type="number" name="bedrooms"/>
            </label>
            <label for="">
                Storeys:
                <input type="number" name="storeys"/>
            </label>
            <label for="">
                Garages:
                <input type="number" name="garages"/>
            </label>
        </form>
    </div>
    <hr>
    <button style="margin: 0px auto;display: block;width: 500px;cursor: pointer" onclick="loadData()">search</button>
    <br>
    <table id="userTable">
        <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Bathrooms</th>
            <th>Bedrooms</th>
            <th>Storeys</th>
            <th>Garages</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align: center">No Data</td>
            </tr>
        </tbody>
    </table>
        <div id="loadingIndicator">
            <div class="spinner"></div>
        </div>
    <p id="notFoundMessage" style="display: none;">Data not found.</p>
    </body>
    <script>
        function loadData() {

            let formData = new FormData();
            document.querySelectorAll("input").forEach(function (el) {
                if(el.value){
                    formData.append(el.getAttribute('name'),el.value)
                }
            })
            $.ajax({
                url: '/api/search-by',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loadingIndicator').show();
                },
                success: function(response) {
                    if (response[0].data.length > 0) {
                        $('#notFoundMessage').hide();
                        displayData(response[0].data);
                    } else {
                        displayNotFoundMessage();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                },
                complete: function() {
                    $('#loadingIndicator').hide();
                }
            });
        }
        function displayData(data) {
            var tableBody = $('#userTable tbody');
            tableBody.empty();
            $.each(data, function(index, user) {
                var row = $('<tr>');
                $('<td>').text(user.id).appendTo(row);
                $('<td>').text(user.name).appendTo(row);
                $('<td>').text(user.price).appendTo(row);
                $('<td>').text(user.bathrooms).appendTo(row);
                $('<td>').text(user.bedrooms).appendTo(row);
                $('<td>').text(user.storeys).appendTo(row);
                $('<td>').text(user.garages).appendTo(row);
                tableBody.append(row);
            });
        }

        function displayNotFoundMessage() {
            var tableBody = $('#userTable tbody');
            tableBody.empty();
            $('#notFoundMessage').show();
        }

    </script>
</html>

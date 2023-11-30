<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #8e44ad, #c0392b);
        }

        .container {
            margin: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #table-container,
        #map {
            margin: 10px;
        }

        #table-container {
            overflow: auto;
        }

        .btn-add-location {
            margin-bottom: 10px;
        }

        #map {
            background: #4b5563;
            height: 300px;
        }
    </style>
    <title>YukaTech Nav</title>
</head>
<body>

<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success btn-add-location" data-toggle="modal" data-target="#myModal">
        <i class="fas fa-plus"></i> Add Location
    </button>

    <div class="row">
        <div class="col-md-6">
            <div id="table-container">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Marker</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Home</td>
                        <td>2.45632</td>
                        <td>3.23456</td>
                        <td>#111111</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div id="map"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="locationName">Location Name</label>
                        <input type="text" class="form-control" id="locationName" placeholder="Enter location name">
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" placeholder="Enter longitude">
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" placeholder="Enter latitude">
                    </div>
                    <div class="form-group">
                        <label for="markerColor">Marker Color</label>
                        <input type="text" class="form-control" id="markerColor" placeholder="Enter marker color">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

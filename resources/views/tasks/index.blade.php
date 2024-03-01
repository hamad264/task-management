
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1,
        h2 {
            color: #2c3e50;
            background-color: #ecf0f1;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        h2:hover {
            background-color: #3498db;
        }

        #task-form-container,
        #task-list-container {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        #task-form-container:hover,
        #task-list-container:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        #task-list-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        #task-list-container th,
        #task-list-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        #task-list-container th {
            background-color: #f2f2f2;
        }

        .pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination a,
.pagination span {
    color: #3498db;
    border: 1px solid #3498db;
    padding: 8px 12px;
    margin: 0 5px;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    cursor: pointer;
}

.pagination .prev.disabled,
.pagination .next.disabled {
    cursor: not-allowed;
    pointer-events: none;
}

.pagination .prev:hover,
.pagination .next:hover,
.pagination .active {
    background-color: #3498db;
    color: #fff;
}

    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {

            function handlePaginationClick(url) {

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {

                        $('#task-list-container').html($(data).filter('#task-list-container').html());

                        $('.pagination').html($(data).filter('.pagination').html());
                    },
                    error: function (error) {
                        console.error('Error fetching page:', error);
                    }
                });
            }


            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                handlePaginationClick(url);
            });
        });
    </script>

</head>

<body>
    <h1>Task Management</h1>


    <div id="task-form-container">
        <h2>Add New Task</h2>


        @include('tasks.create_form')
    </div>


    <div id="task-list-container">
        <h2>Task List</h2>

        <div id="task-list-content">
            @include('tasks.task_list')
        </div>


        <div class="pagination" id="pagination-links">
            {{ $tasks->links() }}
        </div>
    </div>
</body>

</html>

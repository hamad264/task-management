
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        #task-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #333; /* Dark text color */
        }

        .form-control {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 6px;
        }

        textarea.form-control {
            resize: vertical; /* Allow vertical resizing of textarea */
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .text-danger {
            color: #dc3545;
            font-size: 14px;
            margin-top: 6px;
        }
    </style>
</head>
<body>

<form id="task-form">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" name="title" class="form-control" placeholder="Task Title" value="{{ old('title') }}">
        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Task Description</label>
        <textarea name="description" class="form-control" placeholder="Task Description">{{ old('description') }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="priority" class="form-label">Priority</label>
        <input type="number" name="priority" class="form-control" placeholder="Priority" value="{{ old('priority') }}" required>
        @error('priority')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
        @error('due_date')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Add Task</button>
</form>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        $('#task-form').submit(function(e) {
            e.preventDefault();

            $('.text-danger').remove();

            $.ajax({
                type: 'POST',
                url: '{{ route('tasks.store') }}',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);


                    var task = response.task;
                    $('table tbody').append(`
                        <tr>
                            <td>${task.title}</td>
                            <td>${task.description}</td>
                            <td>${task.priority}</td>
                            <td>${task.due_date}</td>
                            <td>${task.completed ? 'Yes' : 'No'}</td>
                            <td>
                                <button onclick="updatePriority(${task.id})">Increase Priority</button>
                            </td>
                        </tr>
                    `);
                },
                error: function(response) {
                    console.log(response);


                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('[name="' + key + '"]').after('<div class="text-danger">' + value + '</div>');
                    });
                }
            });
        });
    });
</script>

</body>
</html>

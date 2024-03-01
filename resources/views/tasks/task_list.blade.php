
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .highlight {
            background-color: #FFFF99;
        }
    </style>
</head>
<button onclick="sortTasksByPriority()">Sort by Priority</button>
<table id="tasks-list">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Completed</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr id="task-row-{{ $task->id }}">
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td class="priority">{{ $task->priority }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->completed ? 'Yes' : 'No' }}</td>
                <td>
                    <button onclick="updatePriority({{ $task->id }})">Increase Priority</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<script>


    function updateTaskList(task) {

        var taskRow = $('#task-row-' + task.id);
        var priorityCell = taskRow.find('.priority');


        priorityCell.addClass('highlight');


        priorityCell.text(task.priority);


        setTimeout(function() {
            priorityCell.removeClass('highlight');
        }, 1000);
    }

    function updatePriority(taskId) {
        var currentPriority = $('#task-row-' + taskId + ' .priority').text();
        var newPriority = parseInt(currentPriority) + 1;

        $.ajax({
            type: 'POST',
            url: '/tasks/' + taskId + '/update-priority',
            data: { priority: newPriority },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);


                updateTaskList(response.task);
            },
            error: function(response) {
                console.log(response);
            }
        });
    }

    function updateTaskListForSorting(tasks) {

       var tbody = $('#tasks-list tbody');
       tbody.html('');

       tasks.forEach(function(task) {
           tbody.append(`
               <tr id="task-row-${task.id}">
                   <td>${task.title}</td>
                   <td>${task.description}</td>
                   <td class="priority">${task.priority}</td>
                   <td>${task.due_date}</td>
                   <td>${task.completed ? 'Yes' : 'No'}</td>
                   <td>
                       <button onclick="updatePriority(${task.id})">Increase Priority</button>
                   </td>
               </tr>
           `);
       });
   }


function handleSortResponse(response) {
   console.log('Response received:', response);

   if (response && response.tasks && Array.isArray(response.tasks)) {

       updateTaskListForSorting(response.tasks);
   } else {
       console.error('Sorting tasks failed. Response:', response);
   }
}



   function sortTasksByPriority() {
       console.log('Sorting tasks by priority...');
       $.ajax({
           type: 'GET',
           url: '{{ route('tasks.sortByPriority') }}',
           success: handleSortResponse,
           error: function(response) {
               console.log(response);
               console.error('Invalid response or sorting tasks failed. Response:', response);
           }
       });
   }


</script>



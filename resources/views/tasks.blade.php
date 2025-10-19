@extends('layouts.top')

@section('title', 'Tasks    ')

@section('content')
<div class="tasks">
    <!-- create task form -->
    <h3>Create Task</h3>
    <form id="taskForm">
        <input name="title" type="text" placeholder="Task title" required>
        <input name="description" placeholder="Task description"></textarea>
        <button type="submit">Add Task</button>
    </form>

    <!-- filter buttons -->
    <div class="filter">
        <label for="statusFilter">Filter by status:</label>
        <select id="statusFilter">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="in-progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <!-- tasks listed -->
    <h3>Your Tasks</h3>
    <ul id="taskList"></ul>
    <div id="pagination"></div> 

    <!-- task view box -->
    <div id="taskBox" class="boxOverlay" style="display:none;">
        <div class="boxContent">
            <h2 id="boxTitle"></h2>
            <p id="boxDescription"></p>
            <p><strong>Status:</strong> <span id="boxStatus"></span></p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <!-- edit box -->
    <div id="editBox" class="boxOverlay" style="display:none;">
    <div class="boxContent">
        <h2>Edit Task</h2>
        <form id="editForm">
        <input type="text" id="editTitle" placeholder="Title" required>
        <textarea id="editDescription" placeholder="Description"></textarea>
        <button type="submit">Save</button>
        <button type="button" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
    </div>
</div>
<button class="logoutBtn" id="logoutBtn">Logout</button>
@endsection

@section('scripts')
<script src="{{ asset('js/tasks.js') }}"></script>
@endsection

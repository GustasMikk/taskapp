const token = localStorage.getItem('token');
if (!token) {
    alert('You need to log in first!');
    window.location.href = '/';
}

const list = document.getElementById('taskList');
const filter = document.getElementById('statusFilter');

// load tasks
let currentPage = 1;

async function loadTasks(status = '', page = 1) {
    currentPage = page;

    let url = `/api/tasks?page=${page}`;
    if (status) url += `&status=${status}`;

    const res = await fetch(url, {
        headers: { 'Authorization': 'Bearer ' + token }
    });

    const data = await res.json();
    const tasks = data.data || [];
    list.innerHTML = '';

    if (!Array.isArray(tasks)) {
        list.innerHTML = '<li>Something went wrong loading tasks.</li>';
        return;
    }

    tasks.forEach(t => {
        const li = document.createElement('li');
        const statusColor = {
            'pending': 'gray',
            'in-progress': 'orange',
            'completed': 'green'
        }[t.status] || 'gray';

        li.innerHTML = `
            <div class="task-card">
                <div class="task-title">${t.title}</div>
                <div class="task-desc">${t.description || ''}</div>
                <span style="color:${statusColor};">[${t.status || 'pending'}]</span><br>
                <div class='taskButtons'">
                    <button onclick="viewTask(${t.id})">View</button>
                    <button onclick="openEditModal(${t.id}, '${t.title.replace(/'/g, "\\'")}', \`${t.description || ''}\`)">Edit</button>
                    <button onclick="changeStatus(${t.id}, 'pending')">Set Pending</button>
                    <button onclick="changeStatus(${t.id}, 'in-progress')">In Progress</button>
                    <button onclick="changeStatus(${t.id}, 'completed')">Mark Done</button>
                    <button onclick="deleteTask(${t.id})">Delete</button>
                </div>
            </div>
        `;

        list.appendChild(li);
    });

    renderPagination(data);
}

function renderPagination(data) {
    const paginationContainer = document.getElementById('pagination') || document.createElement('div');
    paginationContainer.id = 'pagination';
    paginationContainer.style.marginTop = '15px';
    paginationContainer.innerHTML = '';

    if (data.prev_page_url) {
        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Previous';
        prevBtn.onclick = () => loadTasks(filter.value, data.current_page - 1);
        paginationContainer.appendChild(prevBtn);
    }

    const pageInfo = document.createElement('span');
    pageInfo.textContent = ` Page ${data.current_page} of ${data.last_page} `;
    paginationContainer.appendChild(pageInfo);

    if (data.next_page_url) {
        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.onclick = () => loadTasks(filter.value, data.current_page + 1);
        paginationContainer.appendChild(nextBtn);
    }

    list.parentNode.appendChild(paginationContainer);
}

// create new task
document.getElementById('taskForm').addEventListener('submit', async e => {
    e.preventDefault();
    const data = {
        title: e.target.title.value,
        description: e.target.description.value
    };

    const res = await fetch('/api/tasks', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    if (res.ok) {
        e.target.reset();
        loadTasks(filter.value, currentPage);
    } else {
        alert('Error creating task');
    }
});

// change status
async function changeStatus(id, newStatus) {
    await fetch(`/api/tasks/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    });
    loadTasks(filter.value, currentPage);
}

// delete task
async function deleteTask(id) {
    if (!confirm('Delete this task?')) return;

    await fetch(`/api/tasks/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    });
    loadTasks(filter.value, currentPage);
}

// filter change
filter.addEventListener('change', e => loadTasks(e.target.value));

// logout
document.getElementById('logoutBtn').addEventListener('click', async () => {
    await fetch('/api/logout', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token }
    });
    localStorage.removeItem('token');
    window.location.href = '/';
});

// view single task
async function viewTask(id) {
    const res = await fetch(`/api/tasks/${id}`, {
        headers: { 'Authorization': 'Bearer ' + token }
    });

    if (!res.ok) {
        alert('Error loading task');
        return;
    }

    const task = await res.json();
    document.getElementById('boxTitle').textContent = task.title;
    document.getElementById('boxDescription').textContent = task.description || 'No description';
    document.getElementById('boxStatus').textContent = task.status;

    document.getElementById('taskBox').style.display = 'flex';
}

function closeModal() {
    document.getElementById('taskBox').style.display = 'none';
}

// edit
let editingTaskId = null;

function openEditModal(id, title, description) {
  editingTaskId = id;
  document.getElementById('editTitle').value = title;
  document.getElementById('editDescription').value = description || '';
  document.getElementById('editBox').style.display = 'flex';
}

function closeEditModal() {
  document.getElementById('editBox').style.display = 'none';
  editingTaskId = null;
}

document.getElementById('editForm').addEventListener('submit', async e => {
  e.preventDefault();

  const newTitle = document.getElementById('editTitle').value;
  const newDescription = document.getElementById('editDescription').value;

  const res = await fetch(`/api/tasks/${editingTaskId}`, {
    method: 'PUT',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      title: newTitle,
      description: newDescription
    })
  });

  if (res.ok) {
    closeEditModal();
    loadTasks(filter.value, currentPage);
  } else {
    const data = await res.json();
    alert(data.message || 'Error updating task');
  }
});

loadTasks();
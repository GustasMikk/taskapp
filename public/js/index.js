document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const data = {
        name: form.name.value,
        password: form.password.value
    };

    const res = await fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const json = await res.json();
    const message = document.getElementById('message');

    if (res.ok) {
        localStorage.setItem('token', json.token);
        message.textContent = 'Login successful';
        setTimeout(() => window.location.href = '/tasks', 1000);
    } else {
        message.textContent = json.message;
    }
});
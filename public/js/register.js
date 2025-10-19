document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const data = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value
    };

    const res = await fetch('/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const json = await res.json();

    if (res.ok) {
        document.getElementById('message').textContent = 
            'Succesfuly registered';
        console.log('User:', json.user);
    } else {
        document.getElementById('message').textContent = (json.message);
    }
});
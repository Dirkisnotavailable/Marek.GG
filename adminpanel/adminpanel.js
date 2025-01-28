document.querySelectorAll('table.Table td').forEach(cell => {
    cell.addEventListener('click', function(event) {
        // Nezmeni prvu a poslednu bunku v tabulke (prva je id a posledna je bud action alebo streamericon)
        if (this.cellIndex === this.parentElement.children.length - 1 || this.cellIndex === 0) {
            return;
        }
        event.stopPropagation(); 
        const editForm = document.getElementById('editForm');
        const editField = document.getElementById('edit-field');
        const editTitle = editForm.querySelector('h2');
        editField.value = this.innerText;
        editTitle.innerText = 'Edit ' + this.closest('table').querySelector('thead th:nth-child(' + (this.cellIndex + 1) + ')').innerText;
        editForm.dataset.userId = this.closest('tr').querySelector('td:first-child').innerText;
        editForm.dataset.column = this.closest('table').querySelector('thead th:nth-child(' + (this.cellIndex + 1) + ')').innerText.toLowerCase();
        editForm.dataset.cellIndex = this.cellIndex;
        editForm.dataset.rowIndex = this.parentElement.rowIndex;
        editForm.style.display = 'block';
    });
});

document.getElementById('edit-user-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const editForm = document.getElementById('editForm');
    const editField = document.getElementById('edit-field');
    const userId = editForm.dataset.userId;
    const column = editForm.dataset.column;
    const cellIndex = editForm.dataset.cellIndex;
    const rowIndex = editForm.dataset.rowIndex;

    const endpoint = window.location.pathname.includes('streamers') ? '/Testik/adminpanel/updatestreamer.php' : '/Testik/adminpanel/updateuser.php';

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            userId: userId,
            column: column,
            newValue: editField.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Field updated to: ' + editField.value);
            document.querySelector('table.Table tbody tr:nth-child(' + rowIndex + ') td:nth-child(' + (parseInt(cellIndex) + 1) + ')').innerText = editField.value;
            document.getElementById('editForm').style.display = 'none';
        } else {
            alert('Error updating field: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating field. Wrong input!!');
    });
});

document.addEventListener('click', function(event) {
    const editForm = document.getElementById('editForm');
    if (editForm.style.display === 'block' && !editForm.contains(event.target)) {
        editForm.style.display = 'none';
    }
});

document.querySelectorAll('.streamer-card').forEach(card => {
    card.addEventListener('click', function() {
        const cardOptions = document.getElementById('cardOptions');
        cardOptions.style.display = 'block';
        cardOptions.dataset.streamerId = this.dataset.streamerId;
    });
});

document.getElementById('deleteStreamer').addEventListener('click', function() {
    const streamerId = document.getElementById('cardOptions').dataset.streamerId;
    if (confirm('Are you sure you want to delete this streamer?')) {
        fetch('/Testik/adminpanel/removestreamerprocess_form.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ streamerId: streamerId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Streamer deleted successfully');
                location.reload();
            } else {
                alert('Error deleting streamer: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting streamer.');
        });
    }
});

document.getElementById('changeRole').addEventListener('click', function() {
    const streamerId = document.getElementById('cardOptions').dataset.streamerId;
    const changeRoleForm = document.getElementById('changeRoleForm');
    changeRoleForm.style.display = 'block';
    changeRoleForm.dataset.streamerId = streamerId;
});

document.getElementById('change-role-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const streamerId = document.getElementById('changeRoleForm').dataset.streamerId;
    const newRole = document.getElementById('newRole').value;
    fetch('/Testik/adminpanel/updatestreamer.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ streamerId: streamerId, column: 'role', newValue: newRole })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Role updated successfully');
            location.reload();
        } else {
            alert('Error updating role: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating role.');
    });
});

document.addEventListener('click', function(event) {
    const cardOptions = document.getElementById('cardOptions');
    if (cardOptions.style.display === 'block' && !cardOptions.contains(event.target)) {
        cardOptions.style.display = 'none';
    }
    const changeRoleForm = document.getElementById('changeRoleForm');
    if (changeRoleForm.style.display === 'block' && !changeRoleForm.contains(event.target)) {
        changeRoleForm.style.display = 'none';
    }
});

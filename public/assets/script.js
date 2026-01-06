document.getElementById('search').addEventListener('keyup', e => {
    const value = e.target.value.toLowerCase();
    document.querySelectorAll('#list li').forEach(li => {
        li.style.display = li.textContent.toLowerCase().includes(value)
            ? 'block'
            : 'none';
    });
});


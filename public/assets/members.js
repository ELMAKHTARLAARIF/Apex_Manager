        const table = document.getElementById('membersTable').getElementsByTagName('tbody')[0];
        let allRows = Array.from(table.getElementsByTagName('tr'));
        const searchInput = document.getElementById('searchInput');

        const rowsPerPage = 5;
        let currentPage = 1;
        let filteredRows = allRows;

        function renderTable() {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            filteredRows.forEach((row, i) => {
                row.style.display = (i >= start && i < end) ? 'table-row' : 'none';
            });
            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            const container = document.getElementById('pagination');
            container.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.style.margin = '0 5px';
                btn.style.padding = '5px 10px';
                if (i === currentPage) btn.style.fontWeight = 'bold';
                btn.onclick = () => {
                    currentPage = i;
                    renderTable();
                }
                container.appendChild(btn);
            }
        }

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(query));
            currentPage = 1;
            renderTable();
        });

        renderTable();
 
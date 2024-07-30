document.getElementById('orderFecha').addEventListener('change', function() {
    var order = this.value;
    var table = document.getElementById('clasesTable').getElementsByTagName('tbody')[0];
    var rows = Array.from(table.rows);

    rows.sort(function(a, b) {
        var dateA = new Date(a.cells[3].innerText);
        var dateB = new Date(b.cells[3].innerText);
        return order === 'asc' ? dateA - dateB : dateB - dateA;
    });

    rows.forEach(function(row) {
        table.appendChild(row);
    });
});
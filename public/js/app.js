document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }
});

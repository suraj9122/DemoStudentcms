fetch('fetch_course_data.php')
.then(response => response.json())
.then(data => {
    // Prepare the data for the chart
    const labels = data.map(item => item.course_name);
    const values = data.map(item => item.student_count);

    // Create the chart
    const ctx = document.getElementById('courseChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Students',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
});
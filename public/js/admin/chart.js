// Chart.js (line chart)
const ctx1 = document.getElementById('chart1').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
            { label: 'Published', data: [0,1,2,0,0], borderColor: 'blue', fill: false },
            { label: 'Unpublished', data: [0,5,8,0,0], borderColor: 'gray', fill: false }
        ]
    }
});
// Chart.js (pie chart)
const ctx2 = document.getElementById('chart2').getContext('2d');

const data = {
    labels: ['Abandoned', 'Needs Revision', 'Approved', 'Pending', 'LostDoc', 'Rejected'],
    datasets: [{
        data: [4, 20, 16, 40, 12, 8], // your percentages
        backgroundColor: [
            'black',    // Abandoned
            'orange',   // Needs Revision
            'green',    // Approved
            'blue',     // Pending
            'gray',     // LostDoc
            'red'       // Rejected
        ]
    }]
};

new Chart(ctx2, {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false // you have a custom legend
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.raw + '%';
                    }
                }
            }
        }
    }
});
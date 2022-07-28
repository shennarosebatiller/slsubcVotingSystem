document.addEventListener('DOMContentLoaded', function () {
    let pres_chart = document.getElementById('pres-chart').getContext('2d');
    let presChart = new Chart(pres_chart, {
        type: 'doughnut',
        data: {
            labels: ['test', 'Batiller, Shenna M.'],
            datasets: [
                {
                    label: 'President',
                    data: ['100000', '5000'],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    title: {
                        display: true,
                        text: 'Candidates',
                    },
                    position: 'right',
                    align: 'start',
                },
            },
        },
    });
});
function serializeForm(form) {
    let data = new FormData(form);
    let serialize_data = '';
    for (let [key, value] of data) {
        console.log(value);
        if (serialize_data != '') {
            serialize_data += '&';
        }
        if (!value) {
            value = '';
        } else {
            serialize_data += `${key}=${value}`;
        }
    }

    return serialize_data;
}
function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    html.replace(/\s/g, "")
    template.innerHTML = html;
    // console.log(template.innerHTML)
    return template.content.firstChild;
}
function itemFocus(selectedItem) {
    checkbox = selectedItem.querySelector("input[type='checkbox']");
    if (checkbox.checked != true) {
        checkbox.checked = true;
        selectedItem.style.transform = 'scale(1.01)';
        // selectedItem.style.borderBottom = '1px solid grey';
        // selectedItem.style.borderTop = '1px solid grey';
        // selectedItem.style.borderRight = '1px solid grey';
        selectedItem.style.backgroundColor = 'white';
        selectedItem.style.transition = '.2s ease-in-out';
    } else {
        selectedItem.style.transform = 'scale(1)';
        selectedItem.style.borderBottom = 'none';
        selectedItem.style.borderTop = 'none';
        selectedItem.style.borderRight = 'none';
        selectedItem.style.backgroundColor = '#f3f3f3';
        checkbox.checked = false;
    }
}

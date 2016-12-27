export function stack_error(data) {
    let content = '';
    Object.keys(data).map(function(key, index) {
        var value = data[key];
        content += '<span style="color: #e74c3c">' + value[0] + '</span><br>';
    });

    swal({
        title: "Error Text!",
        type: 'error',
        text: content,
        html: true
    });
}
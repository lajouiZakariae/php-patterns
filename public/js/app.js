/**
 *
 * @param {string|HTMLElement} element
 * @param { { url: string; successCallback: Function; errorCallback: Function;} }
 */
function postFormData(element, { url, successCallback, errorCallback }) {
    const form =
        typeof element === 'string'
            ? document.getElementById(element)
            : element;

    if (form) {
        form.onsubmit = ev => {
            ev.preventDefault();

            const data = new FormData(ev.target);

            data.append(
                'csrf_token',
                document
                    .querySelector('meta[name="csrf_token"]')
                    .getAttribute('content')
            );

            fetch(url, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                },
                body: data,
            })
                .then(req => req.json())
                .then(successCallback)
                .catch(errorCallback);
        };
    }
}

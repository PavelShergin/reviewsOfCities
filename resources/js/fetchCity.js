
async  function success(pos) {
    $(window).on('load', function() {
        $('#exampleModal').modal('show');
    });
    const crd = pos.coords;
    let query = {
        lat : crd.latitude,
        lon:crd.longitude
    }
    var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address";
    var token = "baeb38753a639e0f10f3bf01eda452d6014b9be4";
    var optionsFetch = {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body: JSON.stringify(query)
    }
    const res =   await  fetch(url, optionsFetch)
        .then(response => response.json())
        .then(result => {return result.suggestions[0].data.city})
        .catch(error => console.log("error", error));


    const quest = document.querySelector('.quest')
    quest.innerHTML = `Ваш город ${res}?`
    const cityinput = document.querySelector('.cityinput')
    cityinput.value = res;

}



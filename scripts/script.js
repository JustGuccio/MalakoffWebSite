

if(document.getElementById("btnVoirPlus")){
    document.addEventListener("DOMContentLoaded", function() { //Fonction qui permet d'afficher la description entière 
        var showMoreBtn = document.getElementById("btnVoirPlus");
        var fullDescription = document.getElementById("DescriptionFull");
        var smallDescription = document.getElementById("DescriptionCourte");
    
        btnVoirPlus.addEventListener("click", function() {
            fullDescription.classList.toggle("hidden");
            DescriptionCourte.classList.toggle("hidden");
    
            if (fullDescription.classList.contains("hidden")) {
                btnVoirPlus.textContent = "Afficher la description complète";
            } else {
                btnVoirPlus.textContent = "Réduire la description";
                
            }
        });
    });
    
}


function submitFormCom() {
    document.getElementById('formCommentaire').submit(); // Soumettre le formulaire
}


/*document.getElementById('selectLieu').addEventListener('change', function() {
    var lieuReception = this.value;
    var dateLivraison = document.getElementById('inputDateR');
    var currentDate = new Date();
    var currentDay = currentDate.getDay(); // 0 pour dimanche, 1 pour lundi, ..., 6 pour samedi
    var currentHour = currentDate.getHours();

    dateLivraison.value = '';

    dateLivraison.removeAttribute('min');
    dateLivraison.removeAttribute('max');

    if (lieuReception === 'Marché') {
        dateLivraison.removeAttribute('disabled');
    } else {
        if ((currentDay === 0 || currentDay === 6) || (currentHour < 8 || currentHour >= 18)) { 
            currentDate.setDate(currentDate.getDate() + (1 + (currentDay === 6 ? 1 : 0)));
        } else if (currentDay === 1 && currentHour >= 18) { 
            currentDate.setDate(currentDate.getDate() + (1 + 1));
        }

        dateLivraison.setAttribute('min', currentDate.toISOString().split('T')[0]);

        if (currentHour < 8 || currentHour >= 18) {
            dateLivraison.setAttribute('disabled', 'disabled');
        } else {
            dateLivraison.removeAttribute('disabled');
        }
    }
});*/


function InputDateFlatpickr(lieuReception) {
    var dateLivraison = document.getElementById('inputDateR');
    var options = {};

    if (lieuReception === 'Marché') {
        options = {
            "enable": [
                function(date) {
                    return (date.getDay() === 4 || date.getDay() === 6);
                }
            ],
            "locale": {
                "firstDayOfWeek": 1, // Commencer la semaine le lundi
                "months": {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                }
            },
            enableTime: true,
            dateFormat: "d/m/Y - H:i",
            time_24hr: true,
            minTime: "09:00",
            maxTime: "12:00",
            altInput: true,
            altFormat: "j F, Y à H:i",
            minDate: new Date().fp_incr(1)
        };
    } else {
        options = {
            "disable": [
                function(date) {
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ],
            "locale": {
                "firstDayOfWeek": 1, // Commencer la semaine le lundi
                "months": {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                }
            },
            enableTime: true,
            dateFormat: "d/m/Y - H:i",
            time_24hr: true,
            minTime: "09:00",
            maxTime: "18:00",
            altInput: true,
            altFormat: "j F, Y à H:i",
            minDate: new Date().fp_incr(1)
        };
    }

    flatpickr(dateLivraison, options);
}

document.addEventListener('DOMContentLoaded', function() {
    var initialLieuReception = document.getElementById('selectLieu').value;
    InputDateFlatpickr(initialLieuReception);
});

document.getElementById('selectLieu').addEventListener('change', function() {
    var lieuReception = this.value;
    InputDateFlatpickr(lieuReception);
});
let mode = document.querySelector(".fa-moon");
const body = document.querySelector("body");
const header = document.querySelector("header");
const articles = document.getElementsByClassName("column");
const page = document.querySelector(".container");



mode.addEventListener('click', () => {
    if (mode.classList.contains("fa-moon")){
        body.classList.add("dark");
        header.classList.add("header-dark");
        for (i = 0; i < articles.length; i++) {
            articles[i].classList.add("column-dark");
          }
        if(page.classList.contains("top-ten")){
            page.classList.add("top-ten-dark");
        }

        mode.classList.remove("fa-moon");
        mode.classList.add("fa-sun");
        mode.setAttribute('title', 'Tryb jasny');
    }
    else{
        body.classList.remove("dark");
        header.classList.remove("header-dark");
                for (i = 0; i < articles.length; i++) {
            articles[i].classList.remove("column-dark");
          }
          if(page.classList.contains("top-ten")){
            page.classList.remove("top-ten-dark");
        }

        mode.classList.remove("fa-sun");
        mode.classList.add("fa-moon");
        mode.setAttribute('title', 'Tryb ciemny');
    }

});
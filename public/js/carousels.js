const configCarouselAdvertisement = {
    type: 'carousel',
    perView: 1,
    startAt: 0,
    hoverpause: true,
    animationDuration: 3000,
    autoplay: 3000,
};
  
if(document.getElementsByClassName('carousel-of-advertisement').length > 0)
    new Glide('.carousel-of-advertisement', configCarouselAdvertisement).mount();

    
const configCarousel = 
    {
    type: 'carousel',
    perView: 11,
    startAt: 0,
    gap: 10,
    //autoplay: 4000,
    breakpoints: {
        1024: 
        {
            perView: 6.76
            },
        768: 
        {
            perView: 4
        },
        480: 
        {
            perView: 3.5
        },
    }
};
  
if(document.getElementsByClassName('nuestros-recomendados').length > 0)
    new Glide('.nuestros-recomendados', configCarousel).mount();
if(document.getElementsByClassName('los-mas-buscados').length > 0)
    new Glide('.los-mas-buscados', configCarousel).mount();
if(document.getElementsByClassName('los-ultimos-cargados').length > 0)
    new Glide('.los-ultimos-cargados', configCarousel).mount();
    
document.addEventListener("DOMContentLoaded", function(event) 
{
    let carrouselYes = document.querySelectorAll(".none-carrousel");
    for (let i = 0; i < carrouselYes.length; i++) 
    {
        carrouselYes[i].classList.remove("none-carrousel");
    }
});
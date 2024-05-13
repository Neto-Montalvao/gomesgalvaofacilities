document.addEventListener('DOMContentLoaded', () => {

    loader = document.querySelector('.loading');

    let intervalocss = setInterval(function(){
        ultimo = document.querySelector('.ultimo_elemento')
        if(window.getComputedStyle(ultimo).display == 'none'){
            clearInterval(intervalocss);
        }
    },200)

    function applyResponsiveStyles() {
        const screenWidth = screen.width;

        if (screenWidth < 600) {
            document.querySelector('body').className = 'mobile';

            window.dispatchEvent(new Event('platmobile'));
        }else{
            document.querySelector('body').className = 'desktop';

            window.dispatchEvent(new Event('platdesktop'));
        }

    }

    applyResponsiveStyles();
    window.addEventListener('resize', applyResponsiveStyles);


    setTimeout(()=>{
        loader.classList.add('some')
    }, 2000)
});



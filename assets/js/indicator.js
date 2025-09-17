document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with the class 'indicator'
    const indicators = document.querySelectorAll('.indicator');

    // Als er indicators zijn gedefinieerd .length checken
   console.log(indicators.length + ' indicators found');

    // De items ophalen (/api/indicator-items)
    fetch('/api/indicator-items')
        .then(response => response.json())
        .then(data => {

            // Process each indicator element
            indicators.forEach(function(indicator) {
                // Get all classes of the element
                const classes = indicator.classList;

                for (const className of classes) {
                    if (className.startsWith('indicator-')) {
                        let indicatorType = className.substring('indicator-'.length);

                        if (data[indicatorType] !== undefined) {
                            // Set the CSS variable to the count value
                            // Change --indicator-count to --indicator-content to match the SCSS
                            indicator.style.setProperty('--indicator-content', `"${data[indicatorType]}"`);
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching indicator data:', error);
        });
});

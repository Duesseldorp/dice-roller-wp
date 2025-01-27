jQuery(document).ready(function($) {
    $('#dr-form').on('submit', function(e) {
        e.preventDefault();

        // Disable the button to prevent multiple clicks
        const $button = $('#dr-form button');
        $button.prop('disabled', true);

        // Clear previous results
        $('#dr-output').html('');

        // Get the number of dice
        const numberOfDice = $('#dr-number-of-dice').val();
        if (!numberOfDice || numberOfDice < 1 || numberOfDice > 10) {
            alert(dr_translations.invalid_input);
            $button.prop('disabled', false); // Re-enable the button
            return;
        }

        // Roll the dice
        const results = [];
        let total = 0;
        const array = new Uint32Array(numberOfDice);
        window.crypto.getRandomValues(array); // Fill the array with random values

        // Function to display dice results with a delay
        function displayResults(index) {
            if (index < numberOfDice) {
                const roll = (array[index] % 6) + 1; // Random number between 1 and 6
                results.push(roll);
                total += roll;

                // Display the current dice result
                $('#dr-output').append(`<p>${dr_translations.dice} ${index + 1}: ${roll}</p>`);

                // Delay before showing the next dice result
                setTimeout(() => {
                    displayResults(index + 1); // Recursive call with delay
                }, 1000); // 1-second delay
            } else {
                // Display the total after all dice results are shown
                $('#dr-output').append(`<p><strong>${dr_translations.total}: ${total}</strong></p>`);

                // Re-enable the button after the roll is complete
                $button.prop('disabled', false);
            }
        }

        // Start displaying results
        $('#dr-output').html(`<p><strong>${dr_translations.roll_dice}:</strong></p>`);
        displayResults(0); // Start with the first dice
    });
});
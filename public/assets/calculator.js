document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('calculator-form');
    const resultsSection = document.getElementById('results-section');
    const errorSection = document.getElementById('error-section');
    const errorMessage = document.getElementById('error-message');
    const calculateBtn = document.getElementById('calculate-btn');

    const VISITS_PER_YEAR = {
        'one_time': 1,
        'quarterly': 4,
        'monthly': 12,
        'weekly': 52
    };

    function formatCurrency(value) {
        return '$' + parseFloat(value).toFixed(2) + ' CAD';
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        form.classList.remove('was-validated');
        resultsSection.classList.add('d-none');
        errorSection.classList.add('d-none');

        calculateBtn.disabled = true;
        calculateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Calculating...';

        var payload = {
            window_count: parseInt(document.getElementById('window_count').value),
            window_type: document.getElementById('window_type').value,
            access_method: document.getElementById('access_method').value,
            service_type: document.querySelector('input[name="service_type"]:checked').value,
            frequency: document.getElementById('frequency').value,
            labour_rate: parseFloat(document.getElementById('labour_rate').value),
            margin_pct: parseFloat(document.getElementById('margin_pct').value),
            engine: document.querySelector('input[name="engine"]:checked').value
        };

        fetch('calculate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function (response) {
            return response.json().then(function (data) {
                return { ok: response.ok, data: data };
            });
        })
        .then(function (result) {
            if (!result.ok || result.data.error) {
                throw new Error(result.data.error || 'Calculation failed. Please try again.');
            }

            var data = result.data;

            document.getElementById('result-labour').textContent = formatCurrency(data.labour_cost);
            document.getElementById('result-materials').textContent = formatCurrency(data.materials_cost);
            document.getElementById('result-subtotal').textContent = formatCurrency(data.subtotal);
            document.getElementById('result-margin-pct').textContent = payload.margin_pct;
            document.getElementById('result-margin').textContent = formatCurrency(data.margin_amount);
            document.getElementById('result-final').textContent = formatCurrency(data.final_price);
            document.getElementById('result-per-window-before').textContent = formatCurrency(data.subtotal / payload.window_count);
            document.getElementById('result-per-window-after').textContent = formatCurrency(data.per_window_cost);

            var recurringSection = document.getElementById('recurring-section');
            if (payload.frequency !== 'one_time') {
                var visits = VISITS_PER_YEAR[payload.frequency];
                document.getElementById('result-per-visit').textContent = formatCurrency(data.final_price);
                document.getElementById('result-annual').textContent = formatCurrency(data.final_price * visits);
                recurringSection.classList.remove('d-none');
            } else {
                recurringSection.classList.add('d-none');
            }

            resultsSection.classList.remove('d-none');
        })
        .catch(function (err) {
            errorMessage.textContent = err.message;
            errorSection.classList.remove('d-none');
        })
        .finally(function () {
            calculateBtn.disabled = false;
            calculateBtn.innerHTML = 'Calculate Estimate';
        });
    });
});

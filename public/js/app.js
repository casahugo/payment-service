const eventTransaction = new EventSource('http://localhost:5001/hub?topic=' + encodeURIComponent('transaction'));
const eventRequest = new EventSource('http://localhost:5001/hub?topic=' + encodeURIComponent('request'));
const eventHook = new EventSource('http://localhost:5001/hub?topic=' + encodeURIComponent('hook'));

Vue.directive('highlightjs', {
    deep: true,
    bind: function (el, binding) {
        // on first bind, highlight all targets
        let targets = el.querySelectorAll('code')
        targets.forEach((target) => {
            // if a value is directly assigned to the directive, use this
            // instead of the element content.
            if (binding.value) {
                target.textContent = binding.value
            }
            hljs.highlightBlock(target)
        })
    },
    componentUpdated: function (el, binding) {
        // after an update, re-fill the content and then highlight
        let targets = el.querySelectorAll('code')
        targets.forEach((target) => {
            if (binding.value) {
                target.textContent = binding.value
            }
            hljs.highlightBlock(target)
        })
    }
});

Vue.directive('momentjs', {
    bind: function (el) {
        el.textContent = moment(el.textContent, "YYYYMMDD").fromNow();
    }
});

new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data : function() {
        return {
            load: false,
            menu: {
              home: 1,
              monitoring: 0,
            },
            requests: ['listening...'],
            transactions: [],
            hooks: [],
            users: [],
        }
    },
    mounted: function() {
        this.load = true;

        axios
            .get('api/v1/monitoring/transactions')
            .then(response => (this.transactions = response.data.items));

        axios
            .get('api/v1/monitoring/hooks')
            .then(response => (this.hooks = response.data.items));

        axios
            .get('api/v1/monitoring/users')
            .then(response => (this.users = response.data.items));

        eventTransaction.onmessage = event => {
            this.transactions.unshift(JSON.parse(event.data).data)
        };

        eventRequest.onmessage = event => {
            this.requests.push(new Object(JSON.parse(event.data)));
        };

        eventHook.onmessage = event => {
            this.hooks.push(new Object(JSON.parse(event.data)));
        };
    },
});

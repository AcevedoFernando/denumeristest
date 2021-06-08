export default {
    state: {
        results: [],
        onSubmit: false,
        count: 0
	},
	getters: {
        results(state) {
          return state.results
        },
        onSubmit(state) {
            return state.onSubmit
        },
        count(state) {
            return state.count
        }
	},
	actions: {
        search(context, form) {
            // Set onSubmit flag
            context.commit("setOnSubmit", true)
            // Request
          axios.get(`/api/v1/postal-codes?limit=${form.limit}&orderBy=${form.orderBy}&state=${form.state}&township=${form.township}`)
              .then(res => {
                  // Set Results
                  context.commit("setResults", res.data.results)
                  // Set results count
                  context.commit("setCount", Number(res.data.count))
                  // Set onSubmit flag
                   context.commit("setOnSubmit", false)
               })
              .catch(() => {
                  // Set onSubmit flag
                  context.commit("setOnSubmit", false)                  
               })
       }
	},
	mutations: {
       setOnSubmit(state, onSubmit) {
            state.onSubmit = onSubmit
        },
        setResults(state, results) {
            state.results = results
        },
        setCount(state, count) {
            state.count = count
        }
	}
}
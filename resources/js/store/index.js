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
          context.commit("setOnSubmit", true)
          axios.get(`/api/v1/postal-codes?limit=${form.limit}&orderBy=${form.orderBy}&state=${form.state}&township=${form.township}`)
              .then(res => {
                   context.commit("setResults", res.data.results)
                   context.commit("setCount", Number(res.data.count))
                   context.commit("setOnSubmit", false)
               })
               .catch(() => {
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
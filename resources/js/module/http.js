import axios from 'axios'

class Http {
  constructor () {
    this.pathfinder = PATHFINDER
    this.axios = axios.create({
      baseURL: this.pathfinder.base
    })
  }

  resolveURL (name, payload = {}, absolute = false) {
    const route = this.pathfinder.routes.find(route => route.name === name)

    if (typeof route === 'undefined') {
      throw new Error(`Route [${name}] not defined`);
    }

    let qs = ''
    let url = ''
    let { uri } = route
    let segments = uri.split('/')
    const params = this.parse(uri)
    const { base } = this.pathfinder
    const paramsHasRequired = params.filter(param => param.required).length > 0
    const payloadIsEmpty = payload === null || Object.keys(payload).length === 0
    const payloadIsNotEmpty = payload !== null && Object.keys(payload).length > 0
    const queryStrings = payloadIsEmpty ? [] : Object.keys(payload).filter(param => params.map(({ name }) => name).includes(param) === false);

    if (paramsHasRequired && payloadIsEmpty) {
      throw new Error(`Missing required parameters for [Route: ${name}] [URI: ${uri}]`);
    }

    params.forEach(param => {
      const { raw, name } = param
      const isParamSupplied = payloadIsNotEmpty && typeof payload[name] !== 'undefined' && payload[name] !== null
      const value = isParamSupplied ? payload[name] : ''
      segments = segments.map(segment => segment.replace(raw, value))
    })
    
    let path = segments.filter(segment => segment.length > 0).join('/')
    
    if (queryStrings.length > 0) {
      let queryStringValues = []

      queryStrings.forEach(key => {
        queryStringValues.push(`${key}=${encodeURIComponent(payload[key])}`);
      })

      qs = queryStringValues.join('&')
    }

    url = absolute ? (path.length > 0 ? [base, path].join('/') : base) : path

    if (qs.length > 0) {
      return [url, qs].join('?')
    }

    return url
  }

  route (name, payload = {}) {
    return {
      url: () => this.resolveURL(name, payload),
      get: (config = {}) => this.get(this.resolveURL(name, payload), config),
      post: (data = {}, config = {}) => this.post(this.resolveURL(name, payload), data, config),
    }
  }

  parse (uri) {
    const matches = uri.match(/\{(.*?)\}/gi)

    if (matches === null) {
      return []
    }

    return matches.map(item => {
      const name = item.replace('{', '').replace('}', '')
      return {
        raw: item,
        name: name.replace('?', ''),
        required: name.includes('?') === false
      }
    })
  }

  post (url, payload = {}, config = {}) {
    return this.axios.post(url, payload, config)
  }

  get (url, config = {}) {
    return this.axios.get(url, config)
  }
}


export const http = new Http()

export default {
  install (Vue) {
    Vue.prototype.$http = http
  }
}
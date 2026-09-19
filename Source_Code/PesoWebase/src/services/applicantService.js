import { api } from './api'

export const applicantService = {
  getPrograms: () => api.programs(),
  getRegions: () => api.geography.regions(),
  getProvinces: (regionId) => api.geography.provinces(regionId),
  getCities: (provinceId) => api.geography.cities(provinceId),
  getBarangays: (cityId) => api.geography.barangays(cityId),
  submit: async (formData) => {
    const csrf = await api.csrfToken()
    formData.set('_token', csrf.token)
    return api.submitApplication(formData)
  },
}

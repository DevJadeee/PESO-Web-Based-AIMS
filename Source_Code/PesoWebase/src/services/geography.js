import { barangays, municipalities, provinces, regions } from 'psgc'

const luzonRegionCodes = new Set([
  'NCR',
  'CAR',
  'Region I',
  'Region II',
  'Region III',
  'Region IV-A',
  'MIMAROPA',
  'Region V',
])

const sourceRegions = regions.all().filter((region) => luzonRegionCodes.has(region.designation))
const sourceProvinces = provinces
  .all()
  .filter((province) => luzonRegionCodes.has(province.region))
const sourceMunicipalities = municipalities
  .all()
  .filter((municipality) => sourceProvinces.some((province) => province.name === municipality.province))

const regionRecords = sourceRegions.map((region, index) => ({
  id: index + 1,
  code: region.designation,
  name: `${region.name} (${region.designation})`,
}))

const regionIds = new Map(regionRecords.map((region) => [region.code, region.id]))
const provinceRecords = sourceProvinces.map((province, index) => ({
  id: index + 1,
  region_id: regionIds.get(province.region),
  name: province.name,
}))

const provinceIds = new Map(provinceRecords.map((province) => [province.name, province.id]))
const cityRecords = sourceMunicipalities.map((municipality, index) => ({
  id: index + 1,
  province_id: provinceIds.get(municipality.province),
  name: municipality.name === 'Quezon' ? 'Quezon City' : municipality.name,
}))

const normalizePlaceName = (name) =>
  name
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/\bcity\b|\bof\b|\bcapital\b/g, '')
    .replace(/[^a-z0-9]/g, '')

const barangaysByCity = new Map()
barangays.all().forEach((barangay) => {
  const key = normalizePlaceName(barangay.citymun)
  const cityBarangays = barangaysByCity.get(key) || []
  cityBarangays.push(barangay)
  barangaysByCity.set(key, cityBarangays)
})

export const localGeography = {
  regions: () => regionRecords,
  provinces: (regionId) =>
    provinceRecords.filter((province) => province.region_id === Number(regionId)),
  cities: (provinceId) =>
    cityRecords
      .filter((city) => city.province_id === Number(provinceId))
      .map((city) => ({ id: city.id, province_id: city.province_id, name: city.name })),
  barangays: (cityId) => {
    const city = cityRecords.find((item) => item.id === Number(cityId))
    const cityBarangays = city ? barangaysByCity.get(normalizePlaceName(city.name)) || [] : []
    return cityBarangays.map((barangay, index) => ({
      id: barangay.code || `${cityId}-${index + 1}`,
      name: barangay.name,
    }))
  },
}

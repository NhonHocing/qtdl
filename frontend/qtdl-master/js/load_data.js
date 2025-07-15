async function loadData(key, apiUrl) {
  // Nếu đã có trong localStorage
  const cached = localStorage.getItem(key);
  if (cached) {
    try {
      return JSON.parse(cached);
    } catch (e) {
      console.error(`Lỗi parse dữ liệu ${key} từ localStorage`, e);
    }
  }

  // Nếu chưa có thì gọi API
  try {
    const res = await fetch(apiUrl);
    if (!res.ok) throw new Error(`Không thể tải dữ liệu ${key} từ API`);
    const data = await res.json();
    localStorage.setItem(key, JSON.stringify(data));
    return data;
  } catch (err) {
    console.error(`Lỗi khi gọi API ${key}:`, err);
    return [];
  }
}
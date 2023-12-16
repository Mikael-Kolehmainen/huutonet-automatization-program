class Data
{
  constructor(url)
  {
    this.url = url;
  }

  async receiveFromBackend() {
    try {
      const response = await fetch(this.url);

      if (response.ok) {
        return await response.text();
      } else {
        throw new Error(`${response.status} ${response.statusText}`);
      }
    } catch (error) {
      console.error(`Request failed: ${error.message}`);
    }
  }
}

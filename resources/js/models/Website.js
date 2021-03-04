import WebsiteRequest from './WebsiteRequest';

export default function Website({ id, name, url, last_request}) {
    this.id = id;
    this.name = name;
    this.url = url;
    this.last_request = last_request ? new WebsiteRequest(last_request) : null;
  }
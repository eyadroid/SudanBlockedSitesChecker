export default function Website({ id, created_at, available}) {
    this.id = id;
    this.created_at = created_at;
    this.available = available == 1;
  }
export interface Banner {
  id: string;
  name: string;
  alt: string | null;
  link: string;
  target: string;
  image: string;
  placement?: string;
  schedule_data?: ScheduleEntry[];
}

export interface ScheduleEntry {
  day: number;
  hour: number;
}

export type ScheduleGrid = boolean[][]; // [day][hour]

export interface BannerAutocompleteItem {
  id: string
  name: string
}

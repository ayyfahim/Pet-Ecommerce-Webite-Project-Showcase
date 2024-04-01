interface IBadge {
  img: string;
  alt: string;
}

interface IIcon {
  img: string;
  alt: string;
}

interface ICategory {
  id: string;
  badge: IBadge;
  description: string;
  icon: IIcon;
  name: string;
  slug: string;
}

interface IChildren {
  data: ICategory[]
}

export interface IMainCategory {
  id: string;
  badge: IBadge;
  description: string;
  icon: IIcon;
  name: string;
  slug: string;
  children: IChildren
}
export interface Post {
    id: number;
    type: string;
    creatorId: number;
    subtheme1: number;
    subtheme2: number | null;
    subtheme3: number | null;
    name: string;
    description: string;
    originalCode: boolean;
    link: string;
    linkDemo: string;
    verifiedLink: boolean;
}

export interface PostType {
    id: number;
    type: string;
}

export interface Subtheme {
    id: number;
    themeId: number;
    name: string;
}

export interface Theme {
    id: number;
    name: string;
}

export interface User {
    id: number;
    username: string;
    email: string;
    password: string;
    role: string;
    premiumExpire: Date | null;
    isPremium: boolean;
    registerDate: Date | null;
    verified: boolean;
}
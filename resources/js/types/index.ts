export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Member {
    id: number;
    name: string;
    email: string;
    pendidikan_terakhir?: string;
}

export interface PageProps {
    auth: {
        user?: User;
        member?: Member;
    };
    name: string;
    sidebarOpen?: boolean;
    [key: string]: unknown;
}

export interface LearningPackage {
    id: number;
    name: string;
    slug: string;
    category: string;
    question_count: number;
    participants_count: number;
    price: number;
    status: string;
    icon: string;
    tone: string;
    show_participant_preview: boolean;
}

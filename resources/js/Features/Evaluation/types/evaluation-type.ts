export interface Evaluation {
    id: string;
    title: string;
    description: string;
    created_at: string;
}

export interface Message {
    id: string;
    evaluation_id: string;
    sender: MessegeSenderType;
    message: string;
}

export type MessegeSenderType = "assistant" | "user";

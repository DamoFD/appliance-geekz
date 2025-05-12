import { useState, useEffect } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { IoArrowBack } from "react-icons/io5";
import BlueSwirl from '/public/images/blue-swirl.png';
import { FaArrowRight } from "react-icons/fa6";
import { AiOutlineLoading3Quarters } from "react-icons/ai";
import axiosClient from '../axios-client';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import Markdown from 'react-markdown';

const Chat = () => {
    const { appliance } = useAppliance();
    const location = useLocation();
    const query = new URLSearchParams(location.search);
    const faultCode = query.get('code');
    const testMode = query.get('test-mode');

    const defaultChat = [
        {
            role: 'assistant',
            content: 'Hello there, my name is ChatGPT, How can I help with your appliance?  \n **Brand:** ' + (appliance.brand || 'Unknown') + '  \n **Model:** ' + (appliance.model || 'Unknown') + '  \n **Serial:** ' + (appliance.serial || 'Unknown'),
        },
        ...(faultCode
                ? [{ role: 'user', content: `What does the error code ${faultCode} mean, and what are the causes of this fault?` }]
                : []),
        ...(testMode
                ? [{ role: 'user', content: 'How do I enter diagnostic mode to see error codes and test components?' }]
                : [])
    ];

    const navigate = useNavigate();
    const [chat, setChat] = useState(defaultChat);
    const [loading, setLoading] = useState(false);
    const [input, setInput] = useState('');

    useEffect(() => {
        scrollToBottom();
        if (faultCode) getChat(defaultChat);
        if (testMode) getChat(defaultChat);
    }, []);

    useEffect(() => {
        scrollToBottom();
    }, [chat]);

    const scrollToBottom = () => {
        window.scrollTo(0, document.body.scrollHeight);
    }

    const getChat = (chatData = chat) => {
        setLoading(true);
        setTimeout(() => {

        axiosClient.post('/chat', {
            brand: appliance.brand || 'Unknown',
            model: appliance.model || 'Unknown',
            serial: appliance.serial || 'Unknown',
            chat: chatData,
        })
            .then(({data}) => {
                setLoading(false);
                const responseChat = [ ...chatData, { role: 'assistant', content: data.assistant } ]
                setChat(responseChat);
            })
            .catch(() => {
                setLoading(false);
                console.error('error fetching chat');
            });
        }, 1000);
    }

    const onClick = ({ content }) => {
        const updatedChat = [...chat, { role: 'user', content }];
        setChat(updatedChat);
        setInput('');
        getChat(updatedChat);
    };

    const back = () => {
        navigate(-1);
    }

    return (
        <div className="min-h-screen w-full bg-dark-900 px-8 pt-10 pb-48 relative">
            <div className="fixed bg-dark-900 z-[3] top-0 left-0 w-full flex items-center p-4">
            <IoArrowBack onClick={back} className="text-white size-6 cursor-pointer" />
            </div>
            <div className="w-full mt-4 flex flex-col gap-8">
                {chat.map((message, index) =>
                    message.role === 'assistant' ? (
                        <AiChatBubble key={index} message={message.content} />
                    ) : (
                        <UserChatBubble key={index} message={message.content} />
                    )
                )}
                {loading && (
                    <div className="w-full flex items-center space-x-2">
                        <img src={BlueSwirl} alt="blue swirl" className="w-8" />
                        <AiOutlineLoading3Quarters className="text-white animate-spin" />
                        <p className="font-inter text-secondary">Analyzing manuals... Please wait.</p>
                    </div>
                )}
            </div>
            <div className="fixed bottom-4 left-1/2 -translate-x-1/2 w-10/12 z-[3]">
                <textarea
                    className="w-full rounded-lg secondary-gradient text-white font-inter py-4 pl-4 pr-12"
                    rows="3"
                    placeholder="Ask, write, or search for anything..."
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    onKeyDown={(e) => e.key === 'Enter' && onClick({ content: input })}
                >
                </textarea>
                {loading ? (
                    <div className="absolute bottom-3 right-3 size-8 rounded-full primary-gradient flex items-center justify-center">
                        <AiOutlineLoading3Quarters className="text-white animate-spin" />
                    </div>
                ) : (
                    <button
                        className="absolute bottom-3 right-3 size-8 rounded-full primary-gradient flex items-center justify-center"
                        onClick={() => onClick({ content: input })}
                    >
                        <FaArrowRight className="text-white" />
                    </button>
                )}
                <div id="chat-container" />
            </div>
        </div>
    );
}

const UserChatBubble = ({ message }) => {
    return (
        <div className="w-full relative">
            <div className="w-full primary-gradient p-4 rounded-lg text-white font-inter relative z-[2]">
                <p>{message}</p>

            </div>
            <div className="absolute bottom-0 right-[-6px] size-6 bg-[#041920] rounded-full" />
            <div className="absolute bottom-0 right-[-12px] size-2 bg-[#041920] rounded-full" />
        </div>
    );
}

const AiChatBubble = ({ message }) => {
    return (
        <div className="w-full flex items-start space-x-2">
            <img src={BlueSwirl} alt="blue swirl" className="w-8" />
            <div className="secondary-gradient p-4 rounded-lg text-white font-inter w-full flex flex-col space-y-4 markdown-area">
                <Markdown>{message}</Markdown>
            </div>
        </div>
    );
}

export default Chat;

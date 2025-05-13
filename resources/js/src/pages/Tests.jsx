import React, { useState, useEffect } from 'react';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { useNavigate } from 'react-router-dom';
import { IoArrowBack } from "react-icons/io5";
import axiosClient from '../axios-client';
import Markdown from 'react-markdown';
import BlueSwirl from '/public/images/blue-swirl.webp';
import { AiOutlineLoading3Quarters } from "react-icons/ai";

const Tests = () => {
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }
    const { appliance } = useAppliance();
    const [response, setResponse] = useState('');
    const [loading, setLoading] = useState(true);
    const [feedBackVisible, setFeedBackVisible] = useState(false);
    const [aiUsageId, setAiUsageId] = useState('');
    const [feedbackLoading, setFeedbackLoading] = useState(false);

    useEffect(() => {
        getSteps();
    }, []);

    const getSteps = () => {
        setLoading(true);
        axiosClient.get(`/test-mode/`, {
            params: {
                brand: appliance.brand,
                model: appliance.model,
                serial: appliance.serial
            }
        })
            .then(({data}) => {
                setLoading(false);
                setResponse(data.assistant);
                setAiUsageId(data.ai_usage_id);
                setFeedBackVisible(true);
            })
            .catch((err) => {
                setLoading(false);
                if (err.response.data.error) {
                    alert(err.response.data.error);
                }
                console.error('error fetching test mode');
            });
    }

    const sendFeedback = (feedback) => {
        setFeedbackLoading(true);
        axiosClient.post('/feedback', {
            ai_usage_id: aiUsageId,
            feedback: feedback
        })
            .then(({data}) => {
                setFeedBackVisible(false);
            })
            .catch(() => {
                console.error('error sending feedback');
                setFeedBackVisible(false);
            });
    }

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8 lg:py-12 lg:px-[500px]">
            <IoArrowBack onClick={back} className="text-white size-6 cursor-pointer" />
            <h1
                className="font-inter font-bold text-5xl primary-text-gradient mt-4"
            >
                Enter<br />Test Mode
            </h1>
            {loading ? (
                <div className="w-full flex items-center space-x-2 mt-4">
                    <img src={BlueSwirl} alt="blue swirl" className="w-8" />
                    <AiOutlineLoading3Quarters className="text-white animate-spin" />
                    <p className="font-inter text-secondary">Analyzing manuals... Please wait.</p>
                </div>
            ) : (
                    <div className="text-white font-inter w-full flex flex-col space-y-4 markdown-area mt-4">
                        <Markdown>{response}</Markdown>
                    </div>
                )
            }
            {feedBackVisible && (
                <div className="bg-gray-800 p-4 rounded-lg fixed bottom-4 right-4 z-10 flex flex-col items-end space-y-2">
                    <p className="font-inter text-white font-bold cursor-pointer" onClick={() => setFeedBackVisible(false)}>X</p>
                    <p className="font-inter text-white">Was this response helpful?</p>
                    <div className="flex items-center justify-between mt-2 w-full">
                        <button disabled={feedbackLoading} onClick={() => sendFeedback('yes')} className="bg-blue-500 text-white py-2 px-4 rounded-lg">
                            {feedbackLoading ? 'Sending...' : 'Yes'}
                        </button>
                        <button disabled={feedbackLoading} onClick={() => sendFeedback('no')} className="bg-red-500 text-white py-2 px-4 rounded-lg">
                            {feedbackLoading ? 'Sending...' : 'No'}
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}

export default Tests;

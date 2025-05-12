import React, { useState, useEffect } from 'react';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { useNavigate } from 'react-router-dom';
import { IoArrowBack } from "react-icons/io5";
import axiosClient from '../axios-client';
import Markdown from 'react-markdown';
import BlueSwirl from '/public/images/blue-swirl.png';
import { AiOutlineLoading3Quarters } from "react-icons/ai";

const Tests = () => {
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }
    const { appliance } = useAppliance();
    const [response, setResponse] = useState('');
    const [loading, setLoading] = useState(true);

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
            })
            .catch(() => {
                setLoading(false);
                console.error('error fetching test mode');
            });
    }

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8">
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
        </div>
    );
}

export default Tests;

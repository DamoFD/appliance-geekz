import React, { useState, useEffect } from 'react';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { useNavigate, Link } from 'react-router-dom';
import { IoArrowBack } from "react-icons/io5";
import { FaArrowRight } from "react-icons/fa";
import axiosClient from '../axios-client';

const Tests = () => {
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }
    const { appliance } = useAppliance();
    const [steps, setSteps] = useState([]);
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
                setSteps(data.steps);
            })
            .catch(() => {
                setLoading(false);
                console.error('error fetching steps');
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
                <p className="text-white font-inter text-lg primary-text-gradient mt-4">Loading...</p>
            ) : (
                    <div>
                        {steps.map((step, index) => {

                            return (
                                <div className="flex gap-4 text-white mt-8 w-full font-inter" key={index}>
                                    <p className="primary-text-gradient font-bold text-3xl">{step.step}.</p>
                                    <div className="flex flex-col gap-2">
                                        <p className="font-bold text-3xl">{step.title}</p>
                                        <p className="text-secondary">{step.description}</p>
                                        <div />
                                        <Link className="text-[#1796BD] flex items-center cursor-pointer">
                                            <p className="underline">Ask about this step</p>
                                            <FaArrowRight className="size-4 ml-2" />
                                        </Link>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                )
            }
        </div>
    );
}

export default Tests;

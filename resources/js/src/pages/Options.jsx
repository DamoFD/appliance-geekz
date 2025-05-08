import { useAppliance } from '../contexts/ApplianceContextProvider';
import { IoArrowBack } from "react-icons/io5";
import { useNavigate } from 'react-router-dom';
import { FaRegListAlt } from "react-icons/fa";
import { MdOutlineScience } from "react-icons/md";
import { BsChatLeftText } from "react-icons/bs";
import { Link } from 'react-router-dom';

const Options = () => {
    const { appliance } = useAppliance();
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8">
            <IoArrowBack onClick={back} className="text-white size-6 cursor-pointer" />
            <h1
                className="font-inter font-bold text-5xl primary-text-gradient mt-4"
            >
                Let's Get<br />This Resolved
            </h1>
            <div className="mt-10 flex flex-col gap-4 font-inter">
                <div>
                    <p className="text-secondary text-xl">Brand</p>
                    <p className="primary-text-gradient text-3xl font-bold">{appliance.brand || 'Unknown'}</p>
                </div>
                <div>
                    <p className="text-secondary text-xl">Model</p>
                    <p className="primary-text-gradient text-3xl font-bold">{appliance.model || 'Unknown'}</p>
                </div>
                <div>
                    <p className="text-secondary text-xl">Serial</p>
                    <p className="primary-text-gradient text-3xl font-bold">{appliance.serial || 'Unknown'}</p>
                </div>
            </div>
            <p
                className="text-white font-inter text-lg primary-text-gradient mt-10"
            >
                What do you need help with?
            </p>
            <Link to="/dashboard/faults" className="w-full mt-4 secondary-gradient rounded-lg p-4 flex">
                <FaRegListAlt className="text-white size-8 mt-1" />
                <div className="flex flex-col ml-4 font-inter">
                    <p className="text-white text-2xl">Error List</p>
                    <p className="text-secondary">Shows common fault codes for your model</p>
                </div>
            </Link>
            <Link to="/dashboard/tests" className="w-full mt-4 secondary-gradient rounded-lg p-4 flex">
                <MdOutlineScience className="text-white size-8 mt-1" />
                <div className="flex flex-col ml-4 font-inter">
                    <p className="text-white text-2xl">Test Mode</p>
                    <p className="text-secondary">Step-by-step instructions to enter diagnostics</p>
                </div>
            </Link>
            <Link to="/dashboard/chat" className="w-full mt-4 primary-gradient rounded-lg p-4 flex">
                <BsChatLeftText className="text-white size-8 mt-1" />
                <div className="flex flex-col ml-4 font-inter">
                    <p className="text-white text-2xl">Chat Help</p>
                    <p className="text-secondary">Ask questions and get AI-powered repair guidance</p>
                </div>
            </Link>
        </div>
    );
}

export default Options;
